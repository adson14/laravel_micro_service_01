<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    protected $repository;
    public function __construct(Company  $model)
    {
        $this->repository = $model;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CompanyResource::collection($this->repository->with('category')->get());
    }

    /**
     * @param CompanyCreateRequest $request
     * @return CompanyResource
     */
    public function store(CompanyCreateRequest $request)
    {
        $company = $this->repository->create($request->validated());
        return new CompanyResource($company);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($uuid)
    {
        $company = $this->repository->where('uuid',$uuid)->firstOrFail();
        return new CompanyResource($company);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function update(CompanyUpdateRequest $request, $uuid)
    {
        //ADS
        $company = $this->repository->where('uuid',$uuid)->firstOrFail();
        $company->update($request->validated());
        return response()->json(['message'=>'Updated'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $uuid
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        $company = $this->repository->where('uuid',$uuid)->firstOrFail();
        $company->delete();
        return response()->json(['message'=>'Deleted'],204);
    }
}
