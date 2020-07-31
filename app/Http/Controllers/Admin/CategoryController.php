<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Child_category;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        //
        return view('admin.categories.index', [
            'categories' => Category::orderBy('created_at', 'desc')->orderBy('id', 'desc')->paginate(10),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create()
    {
        //
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreCategoryRequest  $request
     * @return Redirector|RedirectResponse
     */
    public function store(StoreCategoryRequest $request)
    {
//        dd([$request->all()]);
        $category = Category::create(['title' => $request->category_title]);
        if ($request->subcategory_title && is_array($request->subcategory_title)){
            foreach ($request->subcategory_title as $subcategory_title) {
                foreach ($subcategory_title as $new_subcategory_title){
                    if ($new_subcategory_title) Child_category::create(['title'=> $new_subcategory_title, 'category_id' => $category->id]);
                }
            }
        }

        return redirect(route('admin.category.index'))
            ->with(['success' => '"' . $category->title . '" category successfully created']);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
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
     * @return View
     */
    public function edit(Category $category)
    {
        //
//        dd('edit method', $category);
        return view('admin.categories.update', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreCategoryRequest $request
     * @param  \App\Category  $category
     * @return Redirector|RedirectResponse
     */
    public function update(StoreCategoryRequest $request, Category $category)
    {
        //
//        dd('update method', $category, $request->get('subcategory_title'));
        $subcategories = $category->child_categories;
        $category->update([
            'title' => $request->get('category_title'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);
//        dd($request->all());

        foreach ($subcategories as $subcategory){
            if (!$request->get('subcategory_title')) {
                $subcategory->delete();
            } else {
                if (!array_key_exists($subcategory->title, $request->get('subcategory_title'))){
                    $subcategory->delete();
                }
            }
        }

        if ($request->get('subcategory_title') && is_array($request->get('subcategory_title'))){
            foreach ($request->subcategory_title as $old_subcategory_title => $subcategory_data){
                foreach ($subcategory_data as $id => $new_subcategory_title) {
                    if ($id != 0){
                        $subcategory = $subcategories->where('id', $id)->first();
                        $subcategory->title = $new_subcategory_title;
                        $subcategory->save();
                    } elseif ($id == 0){
                        if ($new_subcategory_title) {
                            Child_category::create(['title' => $new_subcategory_title, 'category_id' => $category->id]);
                        }
                    }
                }
            }
        }

        return redirect(route('admin.category.edit', ['category' => $category]))
            ->with(['success' => '"' . $category->title . '" category successfully updated']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return Redirector|RedirectResponse
     */
    public function destroy(Category $category)
    {
        //
//        dd('destroy method', $category);
        try {
            $category->delete();
        } catch (\Exception $e) {
            return back('Something went wrong')->withInput();
        }
        return redirect(route('admin.category.index'))
            ->with(['success' => '"' . $category->title . '" category successfully deleted']);
    }
}
