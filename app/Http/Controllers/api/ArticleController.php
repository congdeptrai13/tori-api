<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Repositories\Article\ArticleEloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $articleRepository;
    public function __construct(ArticleEloquentRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }
    /**
     * Display a listing of the resource.
     */

    public function index()
    {
        //
        $listArticle = $this->articleRepository->getAll();
        return response()->json([
            "message" => "success",
            "data" => $listArticle
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $validator = validator($request->all(), [
            'content' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = array_merge(
            $request->all(),
            ["user_id" => Auth::id()]
        );
        $result = $this->articleRepository->create($data);
        if (!$result) {
            return response()->json(
                ["message" => "failed"]
            );
        }
        return response()->json([
            "message" => "success",
            "data" => $result
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //validate
        $company = $this->articleRepository->find($id);
        if (!$company) {
            return response()->json(
                ["message" => "failed"],
                400
            );
        }
        if ($company->user_id !== Auth::id()) {
            return response()->json(
                ["message" => "unauthorize"],
                401
            );
        }

        $validator = validator($request->all(), [
            'content' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        // end validate
        $result = $this->articleRepository->update($id, $request->all());
        return response()->json([
            "message" => "success",
            "data" => $result
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        //validate
        $article = $this->articleRepository->find($id);
        if (!$article) {
            return response()->json(
                ["message" => "failed"],
                400
            );
        }
        $article->delete();
        return response()->json([
            "message" => "success"
        ], 200);
    }
}
