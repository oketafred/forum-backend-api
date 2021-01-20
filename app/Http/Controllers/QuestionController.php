<?php

namespace App\Http\Controllers;

use App\Http\Resources\QuestionResource;
use App\Models\Question;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class QuestionController extends Controller
{
    /**
    * @OA\Get(
    *     path="/questions",
    *     summary="Get All Questions",
    *     description="Get All Questions - Questions Collection",
    *     tags={"Questions"},
    *     security={{ "apiAuth": {} }},
    *     @OA\Response(response="200", description="Questions Collection", @OA\JsonContent())
    * )
    */
    public function index()
    {
        return QuestionResource::collection(Question::latest()->get());
    }

    /**
    * @OA\Post(
    * path="/questions",
    * summary="Question Create",
    * description="Create a new Question",
    * operationId="questionCreate",
    * tags={"Questions"},
    * @OA\RequestBody(
    *    required=true,
    *    @OA\JsonContent(ref="#/components/schemas/QuestionRequest")
    * ),
    * security={{ "apiAuth": {} }},
    *    @OA\Response(
    *      response=200,
    *      description="Success",
    *      @OA\JsonContent(
    *          @OA\Property(property="message", type="string", example="Question Created Successfully")
    *      )
    *    ),
    * )
    */
    public function store(Request $request)
    {
        $question = Question::create([
            'title' => $request->input('title'),
            'slug' => Str::slug($request->input('title')),
            'body' => $request->input('body'),
            'category_id' => $request->input('category_id'),
            'user_id' => auth()->id()
        ]);

        return response()->json($question, Response::HTTP_CREATED);
    }

    /**
    * @OA\Get(
    *     path="/questions/{slug}",
    *     summary="Get a Specific Question",
    *     description="Get a Specific Question by passing the question slug as the parameter",
    *     tags={"Questions"},
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
    *   )
    *)
    */
    public function show(Question $question)
    {
        return new QuestionResource($question);
    }

    /**
     * @OA\Put(
     * path="/questions/{slug}",
     * summary="Update a Specific Question",
     * description="Update a Specific Question by passing the question slug as the parameter",
     * operationId="updateQuestion",
     * tags={"Questions"},
     * @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/QuestionRequest")
     *    ),
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *    response=200,
     *    description="Success"
     *  ),
     * @OA\Parameter(
     *    name="slug",
     *    required=true,
     *    description="Category Slug",
     *    in="path",
     *    @OA\Schema(
     *       type="string"   
     *    )
     *  )
     * )
    */
    public function update(Request $request, Question $question)
    {
        $question->update($request->all());
        return response()->json(new QuestionResource($question), Response::HTTP_ACCEPTED);
    }

    /**
    * @OA\Delete(
    *     path="/questions/{slug}",
    *     summary="Delete a Specific Question",
    *     description="Delete a Specific Question by passing the question slug as the parameter",
    *     tags={"Questions"},
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
    *   )
    *)
    */
    public function destroy(Question $question)
    {
        $question->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
