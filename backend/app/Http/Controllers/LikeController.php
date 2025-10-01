<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Swipe;
use Illuminate\Support\Facades\Auth;

/**
 * @OA\Tag(name="Likes", description="Liked users endpoints")
 */
class LikeController extends Controller
{
    /**
     * Get list of users the authenticated user has liked
     *
     * @OA\Get(
     *     path="/api/liked-users",
     *     tags={"Likes"},
     *     summary="Get liked users",
     *     security={{"sanctum":{}}},
     *     @OA\Response(response=200, description="List of liked users"),
     *     @OA\Response(response=401, description="Unauthorized")
     * )
     */
    public function likedUsers(Request $request)
    {
        $user = Auth::user();

        $likedUsers = Swipe::where('swiper_id', $user->id)
        ->where('type', 'like')
        ->with('swipee:id,name,profile_photo,bio,age,gender')
        ->paginate(20)
        ->through(fn($swipe) => $swipe->swipee);

        return response()->json([
            'success' => true,
            'data' => $likedUsers
        ]);
    }
}
