<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class OrderController extends Controller
{
    public function index(Request $request)
    {
        $todayDate = Carbon::now()->format('Y-m-d'); //'2023-06-21';
        //$orders = Order::whereDate('created_at', $todayDate)->paginate(10);

        $orders = Order::when($request->date != null,function ($q) use ($request){
            return $q->whereDate('created_at',$request->date);
        },function ($q) use ($todayDate){
            return $q->whereDate('created_at',$todayDate);
        })->when($request->status != null, function ($q) use ($request){
            return $q->where('status_message',$request->status);
        })
            ->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($order_id)
    {
        $order = Order::where('id',$order_id)->first();
        if($order){
            return view('admin.orders.view',compact('order'));
        }else{
            return to_route('admin.orders.index')->with('message','Order Id not found');
        }
    }

    public function updateOrderStatus($order_id,Request $request)
    {
        $order = Order::where('id',$order_id)->first();
        if($order){
            $order->update(['status_message' =>$request->order_status]);
            return to_route('admin.orders.show', ['order_id' => $order_id])->with('message','Order Status Updated');
        }else{
            return to_route('admin.orders.show', ['order_id' => $order_id])->with('message','No Order Found');
        }
    }

    public function viewInvoice($order_id)
    {
        $order = Order::findOrFail($order_id);
        return view('admin.invoice.generate-invoice',compact('order'));
    }

    public function generateInvoice($order_id)
    {
        $order = Order::findOrFail($order_id);
        $data = ['order'=>$order];

        $pdf = Pdf::loadView('admin.invoice.generate-invoice', $data);
        $todayDate = Carbon::now()->format('d-m-Y');
        return $pdf->download('invoice-'.$order->id.'-'.$todayDate.'.pdf');

    }
}
