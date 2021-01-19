<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Models\Question;
use App\Models\Reply;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReplyController extends Controller
{
    /**
    * @OA\Get(
    *     path="/question/{slug}/reply",
    *     summary="Get all Replies for a particular question",
    *     description="Get all Replies for a particular question - Replies Collection",
    *     tags={"Reply"},
    *     security={{ "apiAuth": {} }},
    *     @OA\Response(response="200", description="Replies for a particular question", @OA\JsonContent()),
    *     @OA\Parameter(
    *       name="slug",
    *       required=true,
    *       description="Question Slug",
    *       in="path",
    *       @OA\Schema(
    *           type="string"   
    *       )
    *   )
    *)
    */
    public function index(Question $question)
    {
        return ReplyResource::collection($question->replies);
    }

    /**
    * @OA\Post(
    * path="/question/{slug}/reply",
    * summary="Category Create",
    * description="Create a new Reply",
    * operationId="createReply",
    * tags={"Reply"},
    * @OA\RequestBody(
    *      required=true,
    *      @OA\JsonContent(ref="#/components/schemas/ReplyRequest")
    *    ),
    * security={{ "apiAuth": {} }},
    * @OA\Response(
    *      response=200,
    *      description="Success"
    *    ),
    * @OA\Parameter(
    *    name="slug",
    *    required=true,
    *    description="Question Slug",
    *    in="path",
    *    @OA\Schema(
    *       type="string"   
    *    )
    *  )
    * )
    */
    public function store(Question $question, Request $request)
    {
        $reply = $question->replies()->create([
            'body' => $request->input('body'),
            'question_id' => $request->input('question_id'),
            'user_id' => 1
            // 'user_id' => auth()->id()
        ]);
        return response()->json(new ReplyResource($reply), Response::HTTP_CREATED);
    }

    /**
    * @OA\Get(
    *     path="/questions/{slug}/reply/{id}",
    *     tags={"Reply"},
    *     security={{ "apiAuth": {} }},
    *     @OA\Response(response="200", description="Question", @OA\JsonContent()),
    *     @OA\Parameter(
    *       name="slug",
    *       required=true,
    *       description="Question Slug",
    *       in="path",
    *       @OA\Schema(
    *           type="string"   
    *       )
    *   ),
    *   @OA\Parameter(
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
    public function show(Question $question, Reply $reply)
    {
        return new ReplyResource($reply);
    }

    /**
     * @OA\Put(
     * path="/questions/{slug}/reply/{id}",
     * summary="Update a Question",
     * description="Logout user and invalidate token",
     * operationId="authLogout",
     * tags={"Reply"},
     * security={{ "apiAuth": {} }},
     *    @OA\Response(
     *      response=200,
     *      description="Success"
     *    ),
     * )
    */
    public function update(Question $question, Request $request, Reply $reply)
    {
        $reply->update($request->all());
        return response()->json(new ReplyResource($reply), Response::HTTP_ACCEPTED);
    }

    /**
    * @OA\Delete(
    *     path="/questions/{slug}/reply/{id}",
    *     tags={"Reply"},
    *     security={{ "apiAuth": {} }},
    *     @OA\Response(response="200", description="Question", @OA\JsonContent()),
    *     @OA\Parameter(
    *       name="slug",
    *       required=true,
    *       description="Question Slug",
    *       in="path",
    *       @OA\Schema(
    *           type="string"   
    *       )
    *   ),
    *   @OA\Parameter(
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
    public function destroy(Question $question, Reply $reply)
    {
        $reply->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
