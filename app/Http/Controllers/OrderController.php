<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function downloadReceipt($id)
    {
        $order = Order::with('user', 'items.product')->findOrFail($id);
        $pdf = Pdf::loadView('orders.receipt', compact('order'));

        return $pdf->download("Order_Receipt_{$order->id}.pdf");
    }
}
