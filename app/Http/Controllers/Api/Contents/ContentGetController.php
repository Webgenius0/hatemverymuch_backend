<?php

namespace App\Http\Controllers\Api\Contents;

use App\Http\Controllers\Controller;
use App\Models\Content;
use App\Models\User;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class ContentGetController extends Controller
{
        public function getContent ()
        {

            $contents = Content::with('contentsRelationTo_users')->get();

            if ($contents->isEmpty()) {
                return response()->json([
                    'status' => 404,
                    'message' => 'No data found',
                ]);
            }

            return response()->json([
                'status' => 200,
                'message' => 'All Content fetched',
                'data' => $contents
            ]);

        }

    public function getCreator()
    {
        $creators = User::where('subscribe', 1)->get();

        if ($creators->count() === 0) {
            return response()->json([
                'status'  => false,
                'message' => 'No subscribed creators found',
                'data'    => []
            ], 404);
        }

        return response()->json([
            'status'  => true,
            'message' => 'Subscribed creators fetched successfully',
            'data'    => $creators
        ], 200);
    }




    public function myContent(Request $request)
    {
        try {
            // Get currently logged-in user from JWT token
            $user = JWTAuth::parseToken()->authenticate();

            // Fetch only contents created by this user
//            $contents = Content::with('tier') // if you have relation with tier
//            ->where('creator', $user->id)
//                ->get();

            $contents = Content::where('creator', $user->id)->get();

            if ($contents->isEmpty()) {
                return response()->json([
                    'status'  => false,
                    'message' => 'You have not created any content yet',
                    'data'    => []
                ], 404);
            }

            return response()->json([
                'status'  => true,
                'message' => 'Your created contents fetched successfully',
                'data'    => $contents
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'Something went wrong: ' . $e->getMessage()
            ], 500);
        }
    }


}
