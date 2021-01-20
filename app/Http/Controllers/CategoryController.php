<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
    * @OA\Get(
    *     path="/category",
    *     summary="Get all Categories",
    *     description="Get all Categories - Category Collection",
    *     tags={"Category"},
    *     security={{ "apiAuth": {} }},
    *     @OA\Response(response="200", description="Category Collection", @OA\JsonContent())
    * )
     */
    public function index()
    {
        return CategoryResource::collection(Category::latest()->get());
    }

    /**
     * @OA\Post(
     * path="/category",
     * summary="Category Create",
     * description="Create a new Category",
     * operationId="authLogout",
     * tags={"Category"},
     * @OA\RequestBody(
     *    required=true,
     *    @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     * ),
     * security={{ "apiAuth": {} }},
     * @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\JsonContent(
     *          @OA\Property(property="message", type="string", example="Category Created Successfully")
     *        )
     *     ),
     *    ),
     * )
    *
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(CategoryRequest $request)
    {
        $category = new Category;
        $category->name = $request->input('name');
        $category->slug = Str::slug($request->input('name'));
        $category->save();

        return response()->json($category, Response::HTTP_CREATED);
    }

    /**
    * @OA\Get(
    *     path="/category/{slug}",
    *     summary="Get a Specific Category",
    *     description="Get a Specific Category by passing the slug as the parameter",
    *     tags={"Category"},
    *     security={{ "apiAuth": {} }},
    *     @OA\Response(response="200", description="Get a Specific Category", @OA\JsonContent()),
    *     @OA\Parameter(
    *       name="slug",
    *       required=true,
    *       description="Category Slug",
    *       in="path",
    *       @OA\Schema(
    *           type="string"   
    *       )
    *   )
    *)
    */
    public function show(Category $category)
    {
        return new CategoryResource($category);
    }

    
    /**
     * @OA\Put(
     * path="/category/{slug}",
     * summary="Update a Specific Category",
     * description="Update a Specific Category by passing the slug as the parameter",
     * operationId="categoryUpdate",
     * tags={"Category"},
     *    @OA\RequestBody(
     *      required=true,
     *      @OA\JsonContent(ref="#/components/schemas/CategoryRequest")
     *    ),
     *    security={{ "apiAuth": {} }},
     *      @OA\Response(
     *          response=200,
     *          description="Success"
     *      ),
     *    @OA\Parameter(
     *       name="slug",
     *       required=true,
    *       description="Category Slug",
    *       in="path",
    *       @OA\Schema(
    *           type="string"   
    *     )
     *   )
     * )
    */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update([
            'name' => $request->input('name'),
            'slug' => Str::slug($request->input('name')),
        ]);

        return response()->json($category, Response::HTTP_ACCEPTED);
    }

    /**
    * @OA\Delete(
    *     path="/category/{slug}",
    *     summary="Delete a Specific Category",
    *     description="Delete a Specific Category by passing the slug as the parameter",
    *     tags={"Category"},
    *     security={{ "apiAuth": {} }},
    *     @OA\Response(response="200", description="Category", @OA\JsonContent()),
    *     @OA\Parameter(
    *       name="slug",
    *       required=true,
    *       description="Category Slug",
    *       in="path",
    *       @OA\Schema(
    *           type="string"   
    *       )
    *   )
    *)
    */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
