<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Child_category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator as Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.categories.index', [
            'categories' => Category::paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * param  \Illuminate\Http\Request  $request
     * return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
//        dd(['Validation passed', $request->all()]);

        $category = Category::create(['title' => $request->category_title]);
        foreach ($request->subcategory_title as $subcategory_title) {
            if ($subcategory_title) Child_category::create(['title'=> $subcategory_title, 'category_id' => $category->id]);
        }

        return response('Created', 200);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
        dd('show method', $category);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
        dd('edit method', $category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //
        dd('update method', $category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //
        dd('destroy method', $category);
        try {
            $category->delete();
        } catch (\Exception $e) {
            return response('Something went wrong');
        }
        return response('Deleted', 200);
    }
}
