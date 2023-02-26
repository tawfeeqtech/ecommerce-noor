<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Requests\CategoryFormRequest;
use App\Models\Category;
use Illuminate\Support\Facades\File;

class CategoryController extends Controller
{

    public function index()
    {
        return view('admin.category.index');
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(CategoryFormRequest $request)
    {
        $validatedData = $request->validated();

        $category = new Category;

        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['name']);
        $category->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/category/';
            $file = $request->image;

            $filename = time() . '.' . $file->extension();

            //$file->move(public_path('images/category'), $filename);

            $file->move(public_path($uploadPath), $filename);

            $finalImagePathName = $uploadPath  . $filename;

            $category->image = $finalImagePathName;
        }

        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['meta_description'];
        $category->status =  $request->status == true ? '1' : '0';

        $category->save();

        return redirect()->route('category.index')->with('message', 'category has been created successfully');

    }

    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    public function update(CategoryFormRequest $request, $category)
    {
        $validatedData = $request->validated();

        $category = Category::findOrFail($category);

        $category->name = $validatedData['name'];
        $category->slug = Str::slug($validatedData['name']);
        $category->description = $validatedData['description'];

        if ($request->hasFile('image')) {
            $uploadPath = 'uploads/category/';
            $path = public_path($uploadPath) . $category->image;


            if(File::exists($path)){
                File::delete($path);
            }

            $file = $request->image;
            $filename = time() . '.' . $file->extension();
            //$file->move(public_path('images/category'), $filename);

            $file->move(public_path($uploadPath), $filename);

            $finalImagePathName = $uploadPath  . $filename;

            $category->image = $finalImagePathName;
        }

        $category->meta_title = $validatedData['meta_title'];
        $category->meta_keyword = $validatedData['meta_keyword'];
        $category->meta_description = $validatedData['meta_description'];
        $category->status =  $request->status == true ? '1' : '0';

        $category->update();

        return redirect()->route('category.index')->with('message','Category Has Been updated successfully');
    }
}
