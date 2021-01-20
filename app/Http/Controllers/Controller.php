<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *      title="Forum API Documentation", 
     *      version="1.0.0",
     *      description="Forum OpenApi description",
     *      @OA\Contact( 
     *          email="oketafred@gmail.com",
     *      ),
     *     @OA\License(
     *          name="Developed by Oketa Fred",
 *             url="https://www.linkedin.com/in/oketafred/"
     *      )
     * )
     * 
     *@OA\Server(
     *      url=L5_SWAGGER_CONST_HOST,
     *      description="Forum API Server"
     * )
     * 
     * @OA\SecurityScheme(
     *      securityScheme="apiAuth",
     *      in="header",
     *      bearerFormat="JWT",
     *      type="http",
     *      scheme="bearer"
     * )
     */
}
