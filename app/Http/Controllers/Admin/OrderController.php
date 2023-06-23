<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OrderController extends Controller
{
    public function index()
    {
        $todayDate = Carbon::now(); //'2023-06-21';
        $orders = Order::whereDate('created_at', $todayDate)->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($order_id)
    {
        $order = Order::where('id',$order_id)->first();
        if($order){
            return view('admin.orders.view',compact('order'));
        }else{
            return redirect()->back()->with('message','No Order Found');
        }
    }
}
