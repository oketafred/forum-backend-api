<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
* @OA\Schema(
*    title="Store RegisterRequest",
*    description="Store register request body data"
* ),
*/
class RegisterRequest extends FormRequest
{

    /**
    * @OA\Property(
    *    title="name",
    * )
    * @var string
    */
    public $name;

    /**
    * @OA\Property(
    *    title="email",
    * )
    * @var string
    */
    public $email;

    /**
    * @OA\Property(
    *    title="password",
    * )
    * @var string
    */
    public $password;

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
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
        ];
    }
}
