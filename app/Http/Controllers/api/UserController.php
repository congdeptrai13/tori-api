<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\User\UserEloquentRepository;
use App\Repositories\User\UserRepositoryInterface;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

class UserController extends Controller
{
    /**
     * @var PostRepositoryInterface|\App\Repositories\Repository
     */
    protected $userRepository;
    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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
    public function index()
    {
        $listUser = $this->userRepository->getAll();
        return response()->json([
            "message" => "success",
            "data" => $listUser,
            // "count" => count($listUser)
        ]);
    }

    public function edit(Request $request, $user_id)
    {
        $user = $this->userRepository->update($user_id, $request->all());
        if (!$user) {
            return response()->json([
                "message" => "not found user",
            ], 400);
        }
        return response()->json([
            "message" => "update success",
            // "data" => $user
        ], 201);
    }
    public function getUserWithPaginate(Request $request)
    {
        // $listUser = User::where("status", 1)->skip(($request->page - 1) * $request->page_size)->take($request->page_size)->get();
        $listUser = $this->userRepository->getUserWithPaginate($request->page, $request->page_size);
        return response()->json([
            "message" => "success",
            "data" => $listUser
        ], 201);
    }
    public function delete(Request $request, $user_id)
    {
        // $user = User::where("status", 1)->where('id', $request->user_id)->first();
        $user = $this->userRepository->delete($user_id);
        if (!$user) {
            return response()->json([
                "message" => "not found user",
            ], 400);
        }
        return response()->json([
            "message" => "deleted successfully",
        ], 201);
    }
}
