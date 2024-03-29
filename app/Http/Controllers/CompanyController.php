<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyCreateRequest;
use App\Http\Requests\CompanyUpdateRequest;
use App\Http\Resources\CompanyResource;
use App\Models\Company;
use App\Services\EvaluationService;
use Illuminate\Http\Request;

class CompanyController extends Controller
{

    protected $repository;
    protected $evaluationService;
    public function __construct(Company  $model, EvaluationService $evaluationService)
    {
        $this->repository = $model;
        $this->evaluationService = $evaluationService;
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

        $evaluations =  $this->evaluationService->getEvaluationsCompany($uuid);


        return (new CompanyResource($company))->additional(['evaluations' => json_decode($evaluations)]);
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
