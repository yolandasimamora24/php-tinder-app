<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Swipe;
use App\Models\UserMatch;
use App\Models\User;

/**
 * @OA\Tag(name="Swipe", description="Swiping endpoints")
 */
class SwipeController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/swipe",
     *     tags={"Swipe"},
     *     summary="Swipe a user (like or dislike)",
     *     security={{"Bearer": {}}},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"swipee_id","type"},
     *             @OA\Property(property="swipee_id", type="integer"),
     *             @OA\Property(property="type", type="string", enum={"like","dislike"})
     *         )
     *     ),
     *     @OA\Response(response=200, description="Swipe result (match true/false)"),
     *     @OA\Response(response=401, description="Unauthorized")
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
                return response()->json(['match' => true]);
            }
        }

        return response()->json(['match' => false]);
    }

    /**
     * @OA\Get(
     *     path="/api/potential-matches",
     *     tags={"Swipe"},
     *     summary="Get potential users to swipe",
     *     security={{"Bearer": {}}},
     *     @OA\Parameter(name="page", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Parameter(name="limit", in="query", required=false, @OA\Schema(type="integer")),
     *     @OA\Response(response=200, description="Paginated list of users"),
     *     @OA\Response(response=401, description="Unauthorized")
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

        return response()->json($users);
    }
}
