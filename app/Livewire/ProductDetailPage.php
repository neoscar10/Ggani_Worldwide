<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;
use App\Helpers\CartManagement;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Livewire\Partials\Navbar;



#[Title("Product - Detail")]
class ProductDetailPage extends Component
{
    use LivewireAlert;

    public $slug;
    public $quantity = 1;
    public function mount($slug){
        $this->slug = $slug;
    }

    public function increaseQty(){
        $this->quantity++;
    }
    public function decreaseQty(){
        if ($this->quantity > 1){
            $this->quantity--;
        }
    }
    public function addToCart($product_id){
        // dd($product_id);
        $total_count = CartManagement::addItemsToCartwithQty($product_id, $this->quantity);

        // sending an event to nav so as to update dom
        $this->dispatch('update-cart-count', total_count: $total_count)->to(Navbar::class);

        $this->alert('success', 'Product Added To Cart',[
            'position' => 'bottom-end',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail(),
        ]);
    }
}
