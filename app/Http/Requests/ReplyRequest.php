<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
* @OA\Schema(
*    title="Store ReplyRequest",
*    description="Store reply request body data"
* ),
*/
class ReplyRequest extends FormRequest
{

    /**
    * @OA\Property(
    *    title="body",
    * )
    * @var string
    */
    public $body;


    /**
    * @OA\Property(
    *    title="question_id",
    * )
    * @var integer
    */
    public $question_id;

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
            'body' => 'required',
            'question_id' => 'required',
        ];
    }
}
