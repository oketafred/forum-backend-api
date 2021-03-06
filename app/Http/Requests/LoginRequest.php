<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
* @OA\Schema(
*    title="Store LoginRequest",
*    description="Store login request body data"
* ),
*/
class LoginRequest extends FormRequest
{
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
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
