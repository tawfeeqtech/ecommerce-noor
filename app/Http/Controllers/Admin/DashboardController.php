<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(){
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $totalBrand = Brand::count();

        $totalAllUsers = User::count();
        $totalUser = User::where('role_as','0')->count();
        $totalAdmin = User::where('role_as','1')->count();

        $todayDate = Carbon::now()->format('d-m-Y');
        $thisMonth = Carbon::now()->format('m');
        $thisYear  = Carbon::now()->format('Y');

        $totalOrder = Order::count();
        $todayOrder = Order::whereDate('created_at',$todayDate)->count();
        $thisMonthOrder = Order::whereMonth('created_at',$thisMonth)->count();
        $thisYearOrder = Order::whereYear('created_at',$thisYear)->count();


        return view('admin.dashboard',[
            'totalProducts' => $totalProducts,
            'totalCategories' => $totalCategories,
            'totalBrand' => $totalBrand,
            'totalAllUsers' => $totalAllUsers,
            'totalUser' => $totalUser,
            'totalAdmin' => $totalAdmin,
            'totalOrder' => $totalOrder,
            'todayOrder' => $todayOrder,
            'thisMonthOrder' => $thisMonthOrder,
            'thisYearOrder' => $thisYearOrder,
        ]);
    }
}
