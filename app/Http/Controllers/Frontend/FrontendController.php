<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', '0')->get();
        return view('frontend.index', compact('sliders'));
    }

    public function categories()
    {
        $entities = Category::where('status', '0')->get();
        return view('frontend.collections.categories.index', compact('entities'));
    }

    public function products($category_slug)
    {
        $category = Category::where('slug',$category_slug)->first();
        if($category){
            // $entities = $category->products()->get();
            return view('frontend.collections.products.index', [
                // 'entities' => $entities,
                'category' => $category
                
            ]);
        }else{
            return redirect()->back();
        }
    }


}
