<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Title("Products - gadjo")]
class ProductsPage extends Component
{
    use LivewireAlert;
    use WithPagination;
    #[Url]
    public $selected_categories = [];
    #[Url]
    public $selected_brands = [];
    #[Url]
    public $price_range = 2000000;

    #[Url]
    public $sort = "latest";

    // Add to cart mathod
    public function addToCart($product_id){
        // dd($product_id);
        $total_count = CartManagement::addItemsToCart($product_id);

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
        
        $products = Product::query()->where("is_active", 1);
        
        if(!empty($this->selected_categories)){
            $products->whereIn("category_id", $this->selected_categories);
        }
        if(!empty($this->selected_brands)){
            $products->whereIn("brand_id", $this->selected_brands);
        }
        if($this->price_range){
            $products->whereBetween('price', [0, $this->price_range]);
        }

        if($this->sort == "latest"){
            $products->orderBy("created_at","desc");
        }
        if($this->sort == "price"){
            $products->orderBy("price");
        }


        $catrgories = Category::where("is_active",1)->get(['name', 'id', 'slug']);
        return view('livewire.products-page', [
            'products' => $products->paginate(6),
            'categories' => $catrgories,
            'brands' =>Brand::where("is_active",1)->get(['name', 'id', 'slug'])
        ]);
    }
}
