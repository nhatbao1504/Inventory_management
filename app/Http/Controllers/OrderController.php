<?php

namespace App\Http\Controllers;

use App\Models\OrderModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    function getView(){
        $order_project = DB::table('order_project')->get();
        return view('auth.order.order', [
            'order_id' => $order_project->order_id,
            'order_code' => $order_project->order_code,
            'order_name' => $order_project->order_name,
            'order_owner' => $order_project->order_owner,
            'status' => $order_project->status,
            'create_date' => $order_project->create_date,
            'total_price' => $order_project->total_price,
            'VAT' => $order_project->VAT
        ]);
    }

    public function addOrder(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'order_code' => 'required|string|max:255',
            'order_name' => 'required|string|max:255',
            'order_owner' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'create_date' => 'required|date',
            'total_price' => 'required|numeric',
            'VAT' => 'required|numeric',
        ]);

        // Tạo một đơn hàng mới từ dữ liệu đã được kiểm tra
        $order = new OrderModel();
        $order->order_code = $request->input('order_code');
        $order->order_name = $request->input('order_name');
        $order->order_owner = $request->input('order_owner');
        $order->status = $request->input('status');
        $order->create_date = $request->input('create_date');
        $order->total_price = $request->input('total_price');
        $order->VAT = $request->input('VAT');

        // Lưu đơn hàng vào cơ sở dữ liệu
        $order->save();

        // Chuyển hướng hoặc thông báo thành công
        return redirect()->back()->with('success', 'Order added successfully!');
    }
}
