<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Reply;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LikeController extends Controller
{
    /**
     * @OA\Post(
     * path="/like/{id}",
     * summary="Like a Reply",
     * description="Like a reply on a Question by passing the reply id as the parameter",
     * operationId="likeReply",
     * tags={"Like"},
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(),
     * ),
     * @OA\Parameter(
    *       name="id",
    *       required=true,
    *       description="Reply Id",
    *       in="path",
    *       @OA\Schema(
    *           type="integer"   
    *       )
    *   )
     * )
     */
    public function likeIt(Reply $reply)
    {
        $like_count = $reply->like()->where('user_id', '1')->count();
        if($like_count > 0) {
            return response()->json(['error' => 'Reply already liked']);
        }

        $reply->like()->create([
            'user_id' => auth()->id()
        ]);
        return response()->json($reply, Response::HTTP_CREATED);
    }

    /**
    * @OA\Delete(
    *     path="/like/{id}",
    *     summary="unLike a Reply",
    *     description="Like a reply on a Question by passing the reply id as the parameter",
    *     tags={"Like"},
    *     security={{ "apiAuth": {} }},
    *     @OA\Response(response="200", description="unLike a reply", @OA\JsonContent()),
    *     @OA\Parameter(
    *       name="id",
    *       required=true,
    *       description="Reply Id",
    *       in="path",
    *       @OA\Schema(
    *           type="integer"   
    *       )
    *   )
    *)
    */
    public function unLikeIt(Reply $reply)
    {
        $reply->like()->where('user_id', auth()->id())->first()->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
