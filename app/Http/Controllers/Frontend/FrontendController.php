<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', '0')->get();
        $trendingProducts = Product::where('trending','1')->latest()->take(15)->get();
        return view('frontend.index', compact('sliders','trendingProducts'));
    }

    public function thanks()
    {
        return view('frontend.thank-you');
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
    public function productView($category_slug,$product_slug = null)
    {
        $category = Category::where('slug',$category_slug)->first();
        if($category){

            $product = $category->products()->where('slug',$product_slug)->where('status','0')->first();
            if ($product){
                return view('frontend.collections.products.view', [
                    'product' => $product,
                    'category' => $category
                ]);
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }
    }

}
