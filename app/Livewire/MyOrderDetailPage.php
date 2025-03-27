<?php

namespace App\Livewire;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use Livewire\Attributes\Title;
use Livewire\Component;


#[Title("Order Details")]
class MyOrderDetailPage extends Component
{
    public $order_id; //captured from url

    //initalializing order id
    public function mount($order_id){
        $this->order_id = $order_id;
        // dd($order_id);
    }
    public function render()
    {
        $order_items = OrderItem::with('product')->where('order_id', $this->order_id)->get();
        $address = Address::where('order_id', $this->order_id)->first();
        $order = Order::where('id', $this->order_id)->first();
        return view('livewire.my-order-detail-page',[
            'order'=> $order,
            'address'=> $address,
            'order_items'=> $order_items

        ]);
    }
}
