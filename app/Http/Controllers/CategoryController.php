<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryCreateRequest;
use App\Http\Requests\CategoryUpdateRequest;
use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryController extends Controller
{

    protected $repository;
    public function __construct(Category  $model)
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
        return CategoryResource::collection($this->repository->get());
    }

    /**
     * @param CategoryCreateRequest $request
     * @return CategoryResource
     */
    public function store(CategoryCreateRequest $request)
    {
        $category = $this->repository->create($request->validated());
        return new CategoryResource($category);
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function show($url)
    {
        $category = $this->repository->where('url',$url)->firstOrFail();
        return new CategoryResource($category);
    }

    /**
     * @param CategoryUpdateRequest $request
     * @param $url
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(CategoryUpdateRequest $request, $url)
    {
        $category = $this->repository->where('url',$url)->firstOrFail();
        $category->update($request->validated());
        return response()->json(['message'=>'Success']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $url
     * @return \Illuminate\Http\Response
     */
    public function destroy($url)
    {
        $category = $this->repository->where('url',$url)->firstOrFail();
        $category->delete();
        return response()->json([],204);
    }
}
