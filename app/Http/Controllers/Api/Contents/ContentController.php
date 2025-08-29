<?php

namespace App\Http\Controllers\Api\Contents;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Models\Content;
use App\Models\Tag;

// helpers & custom classes
use App\Helpers\StoreImage;
use Illuminate\Database\Eloquent\ModelNotFoundException;
// exceptions
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Storage;
use Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContentController extends Controller
{

	public function allContents()
	{
		try {
			$contents = Content::with('contentsRelationTo_users')->get();

			return response()->json([
				'status' => 200,
				'message' => 'All tags fetched',
				'data' => $contents
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}
	}

	public function createContent(Request $request)
	{
		try {
			if (strtolower(Auth::user()->role) !== 'fans') {
				$validator = Validator::make($request->all(), [
					'tier_id' => 'nullable|integer',
					'title' => ['nullable', 'regex:/^[A-Za-z0-9\s\p{P}]+$/u', 'max:120', 'required_without_all:description,file'],
					'description' => ['nullable', 'string', 'required_without_all:title,file'],
					'tags' => 'required|string|max:90',
					'schedule' => 'nullable|date|after:now',
					'file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,webm,3gp', 'max:102400', 'required_without_all:title,description'],
				]);

				if ($validator->fails()) {
					return response()->json([
						'status' => 422,
						'message' => 'validation error',
						'data' => $validator->errors()->all()
					]);
				}

				$validated = $validator->validated();

				if ($request->hasFile('file')) {

					$files = $request->file('file');

					$latestFile = is_array($files) ? end($files) : $files;

					$validated['file'] = StoreImage::storeFile(
						$latestFile,
						$validated['title'],
						'content-pics',
						'public'
					);
				}

				$content = Content::create([
					'tier_id' => $validated['tier_id'] ?? null,
					'title' => $validated['title'],
					'description' => $validated['description'] ?? null,
					'tags' => $validated['tags'] ?? null,
					'schedule' => $validated['schedule'] ?? null,
					'file' => $validated['file'] ?? null,
					'creator' => Auth::id(),
				]);

				// strip & create unique tags
				$tagsArray = preg_split('/[,|.?!]/', $validated['tags']);
				$tagIds = [];

				foreach ($tagsArray as $tagName) {
					if (!empty($tagName)) {
						$tag = Tag::firstOrCreate(['name' => $tagName]);
						$tagIds[] = $tag->id;
					}
				}

				$content->PivotRelationWith_tags()->sync($tagIds);

				return response()->json([
					'status' => 201,
					'message' => "Post created",
					'data' => $content->load('PivotRelationWith_tags'),
				]);
			} else {

				return response()->json([
					'status' => 405,
					'message' => 'User Unauthorized',
					'previous_url' => url()->previous(),
					'data' => $request->all()
				]);
			}
		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}
	}

	public function showContent($id)
	{
		$content = Content::find($id);

		try {
			if (!$content) {
				return response()->json([
					'status' => 404,
					'message' => 'Content not found'
				]);
			}
			return response()->json([
				'status' => 200,
				'message' => 'All tags fetched',
				'data' => $content
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}
	}

	public function updateContent(Request $request, $id)
	{
		try {
			$content = Content::find($id);

			if (!$content) {
				return response()->json([
					'status' => 404,
					'message' => 'Content not found'
				]);
			}

			if (strtolower(Auth::user()->role) !== 'fans' && $content->creator !== Auth::id()) {
				return response()->json([
					'status' => 403,
					'message' => 'User Unauthorized!',
				]);
			}

			$validator = Validator::make($request->all(), [
				'tier_id' => 'nullable|integer',
				'title' => ['nullable', 'regex:/^[A-Za-z0-9\s\p{P}]+$/u', 'max:120', 'required_without_all:description,file'],
				'description' => ['nullable', 'string', 'required_without_all:title,file'],
				'tags' => 'required|string|max:90',
				'schedule' => 'nullable|date|after:now',
				'file' => ['nullable', 'file', 'mimes:jpeg,png,jpg,gif,webp,mp4,mov,avi,webm,3gp', 'max:102400', 'required_without_all:title,description'],
			]);

			if ($validator->fails()) {
				return response()->json([
					'status' => 422,
					'message' => 'Validation error',
					'data' => $validator->errors()->all()
				]);
			}

			$validated = $validator->validated();

			// Handle file update
			if ($request->hasFile('file')) {
				// when creator uploads file/keeps the existing file
				if ($content->file && Storage::disk('public')->exists($content->file)) {
					Storage::disk('public')->delete($content->file);
				}

				$files = $request->file('file');

				$latestFile = is_array($files) ? end($files) : $files;

				$validated['file'] = StoreImage::storeFile(
					$latestFile,
					$validated['title'] ?? $content->title,
					'content-pics',
					'public'
				);

				$validated['file'] = StoreImage::getNewFileName();
			} else {
				if ($content->file && Storage::disk('public')->exists($content->file)) {
					Storage::disk('public')->delete($content->file);
				}

				$validated['file'] = null;
			}

			// Update content
			$content->update([
				'tier_id' => $validated['tier_id'] ?? $content->tier_id,
				'title' => $validated['title'] ?? $content->title,
				'description' => $validated['description'] ?? $content->description,
				'tags' => $validated['tags'] ?? $content->tags,
				'schedule' => $validated['schedule'] ?? $content->schedule,
				'file' => $validated['file'],
			]);

			// Update tags if provided
			if (!empty($validated['tags'])) {
				$tagsArray = preg_split('/[,|.?!]/', $validated['tags']);
				$tagIds = [];

				foreach ($tagsArray as $tagName) {
					if (!empty(trim($tagName))) {
						$tag = Tag::firstOrCreate(['name' => trim($tagName)]);
						$tagIds[] = $tag->id;
					}
				}

				$content->PivotRelationWith_tags()->sync($tagIds);
			}

			return response()->json([
				'status' => 200,
				'message' => "Post updated successfully",
				'data' => $content->load('PivotRelationWith_tags'),
			]);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}
	}

	public function deleteContent(Content $contentID)
	{
		try {
			// ------our contents starts here--------
			if (strtolower(Auth::user()->role) !== 'fans' && $contentID->creator !== Auth::id()) {
				return response()->json([
					'status' => 403,
					'message' => 'User Unauthorized!',
				], 403);
			}

			$displayContent = ($contentID->title ? str($contentID->title)->limit(20) : null) ?:
				($contentID->description ? str($contentID->description)->limit(20) : null) ?:
				\Illuminate\Support\Str::after($contentID->file, 'content-pics/');

			$contentID->delete();
			// ------our contents ends here--------
			return response()->json([
				'status' => 200,
				'message' => 'Content (' . $displayContent . ') is deleted',
				'data' => ''
			]);

		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			], 500);
		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			], 500);
		}
	}

	public function getAllTags()
	{
		try {
			$tags = Tag::all();

			if ($tags->isEmpty()) {
				return response()->json([
					'status' => 200,
					'message' => 'No tags created yet',
					'data' => []
				]);
			}

			return response()->json([
				'status' => 200,
				'message' => 'All tags fetched',
				'data' => $tags
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}

	}

	public function demo_method()
	{
		try {
			// ------our contents starts here--------

			// ------our contents ends here--------

			return response()->json([
				'status' => 200,
				'message' => 'All tags fetched',
				'data' => ''
			]);

		} catch (\Exception $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Server error: ' . $e->getMessage()
			]);
		} catch (QueryException $e) {
			return response()->json([
				'status' => 500,
				'message' => 'Database error'
			]);
		}
	}

}
