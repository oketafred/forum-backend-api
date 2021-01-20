<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
* @OA\Schema(
*    title="Store CategoryRequest",
*    description="Store category request body data"
* ),
*/

class CategoryRequest extends FormRequest
{

    /**
    * @OA\Property(
    *    title="name",
    * )
    * @var string
    */
    public $name;


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
            'name' => 'required|unique:categories'
        ];
    }
}
