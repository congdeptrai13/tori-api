<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\Company\CompanyEloquentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{

    protected $companyRepository;
    public function __construct(CompanyEloquentRepository $companyRepository)
    {
        $this->companyRepository = $companyRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $listCompany = $this->companyRepository->getAll();
        return response()->json([
            "message" => "success",
            "data" => $listCompany
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        //
        $validator = validator($request->all(), [
            'name' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        $data = array_merge(
            $request->all(),
            ["user_id" => Auth::id()]
        );
        $result = $this->companyRepository->create($data);
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
        //validate
        $company = $this->companyRepository->find($id);
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
            'name' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }
        // end validate
        $result = $this->companyRepository->update($id, $request->all());
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
        $company = $this->companyRepository->find($id);
        if (!$company) {
            return response()->json(
                ["message" => "failed"],
                400
            );
        }
        $company->delete();
        return response()->json([
            "message" => "success"
        ], 200);
    }
}
