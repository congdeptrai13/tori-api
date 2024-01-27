<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{

    /**
     * @OA\Get(
     *      path="/api/hello-world",
     *      operationId="get test",
     *      tags={"Users"},
     *      summary="Get list of test",
     *      description="Returns list of users",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *       ),
     *       @OA\Response(response=400, description="Bad request"),
     *       security={
     *           {"api_key_security_example": {}}
     *       }
     *     )
     *
     * Returns list of projects
     */
    public function index(Requst $request)
    {
        return "hello world";
    }
}
