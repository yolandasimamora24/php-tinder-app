<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Swipe;
use App\Models\UserMatch;

/**
 * @OA\Tag(name="Swipe", description="Swipe & potential match endpoints")
 */
class SwipeController extends Controller
{
    /**
     * Swipe on a user (like or dislike)
     *
     * @OA\Post(
     *     path="/api/swipe",
     *     tags={"Swipe"},
     *     summary="Swipe on a user",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"swipee_id","type"},
     *             @OA\Property(property="swipee_id", type="integer"),
     *             @OA\Property(property="type", type="string", enum={"like","dislike"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Swipe recorded"),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function swipe(Request $request)
    {
        $request->validate([
            'swipee_id' => 'required|exists:users,id',
            'type' => 'required|in:like,dislike'
        ]);

        $swiper = auth()->user();
        $swipeeId = $request->swipee_id;

        Swipe::updateOrCreate(
            ['swiper_id' => $swiper->id, 'swipee_id' => $swipeeId],
            ['type' => $request->type]
        );

        $match = false;

        if ($request->type === 'like') {
            $reverseSwipe = Swipe::where('swiper_id', $swipeeId)
                                 ->where('swipee_id', $swiper->id)
                                 ->where('type', 'like')
                                 ->first();
            if ($reverseSwipe) {
                UserMatch::firstOrCreate([
                    'user_one_id' => min($swiper->id, $swipeeId),
                    'user_two_id' => max($swiper->id, $swipeeId)
                ]);
                $match = true;
            }
        }

        return response()->json(['match' => $match]);
    }

    /**
     * Get potential matches (users not swiped yet)
     *
     * @OA\Get(
     *     path="/api/potential-matches",
     *     tags={"Swipe"},
     *     summary="Get list of potential matches",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         name="page",
     *         in="query",
     *         description="Page number",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="limit",
     *         in="query",
     *         description="Number of results per page",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Paginated list of users"),
     *     @OA\Response(response=401, description="Unauthorized"),
     * )
     */
    public function potentialMatches(Request $request)
    {
        $swiper = auth()->user();

        $page = $request->query('page', 1);
        $limit = $request->query('limit', 10);

        $swipedUserIds = Swipe::where('swiper_id', $swiper->id)->pluck('swipee_id');

        $query = User::whereNotIn('id', $swipedUserIds)
                     ->where('id', '!=', $swiper->id);

        $users = $query->paginate($limit, ['*'], 'page', $page);

        return response()->json([
            'success' => true,
            'data' => $users->items(),
            'current_page' => $users->currentPage(),
            'last_page' => $users->lastPage(),
            'per_page' => $users->perPage(),
            'total' => $users->total(),
        ]);
    }
}
