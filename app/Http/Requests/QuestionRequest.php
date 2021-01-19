<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
* @OA\Schema(
*    title="Store QuestionRequest",
*    description="Store Question request body data"
* ),
*/
class QuestionRequest extends FormRequest
{

    /**
    * @OA\Property(
    *    title="title",
    * )
    * @var string
    */
    public $title;

    /**
    * @OA\Property(
    *    title="body",
    * )
    * @var string
    */
    public $body;

    /**
    * @OA\Property(
    *    title="category_id",
    * )
    * @var integer
    */
    public $category_id;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title'         => 'required',
            'body'          => 'required',
            'category_id'   => 'required|integer',
            'user_id'       => 'required|integer'
        ];
    }
}
