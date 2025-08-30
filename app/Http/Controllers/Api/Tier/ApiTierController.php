<?php

namespace App\Http\Controllers\Api\Tier;

use App\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Resources\TierResource;
use App\Models\Tier;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ApiTierController extends Controller
{
    use ApiResponse;

    public function index()
    {
        try {
            $tiers = Tier::latest()->paginate(10);
            return $this->paginateResponse(TierResource::collection($tiers));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    // Create a new tier
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title'       => 'required|string|max:255',
            'price'       => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse($validator->errors()->first(), 422);
        }

        try {
            $validated = $validator->validated();

            $tier = Tier::create([
                'user_id'     => auth()->id(),
                'title'       => $validated['title'],
                'price'       => $validated['price'] ?? null,
                'description' => $validated['description'] ?? null,
            ]);

            return $this->successResponse(
                new TierResource($tier),
                'Tier created successfully',
                201
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function show($id)
    {
        try {
            $tier = Tier::find($id);

            if (!$tier) {
                return $this->errorResponse('Tier not found', 404);
            }

            return $this->successResponse(
                new TierResource($tier),
                'Tier fetched successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $tier = Tier::find($id);

            if (!$tier) {
                return $this->errorResponse('Tier not found', 404);
            }

            $validator = Validator::make($request->all(), [
                'title'       => 'nullable|string|max:255',
                'price'       => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse($validator->errors()->first(), 422);
            }

            $validated = $validator->validated();

            $tier->update($validated);

            return $this->successResponse(
                new TierResource($tier),
                'Tier updated successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }


    public function destroy($id)
    {
        try {
            $tier = Tier::find($id);
            if (!$tier) {
                return $this->errorResponse('Tier not found', 404);
            }

            $tier->delete();

            return $this->successResponse(
                null,
                'Tier deleted successfully'
            );
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), 500);
        }
    }
}
