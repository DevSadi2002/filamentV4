<?php

namespace App\Livewire;

use App\Helpers\CartMangement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Jantinnerezo\LivewireAlert\Facades\LivewireAlert;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Detail - Hope Store')]
class ProductDetailPage extends Component
{
    public $slug;
    public $quantity = 1;

    public function mount($slug)
    {
        $this->slug = $slug;
    }
    public function decreaseQty()
    {
        if ($this->quantity > 1) {
            return $this->quantity--;
        }
    }
    public function increaseQty(): int
    {
        return $this->quantity++;
    }

    public function addToCart($product_id)
    {
        $total_count = CartMangement::addItem($product_id, $this->quantity);
        $this->dispatch('update-cart-count', $total_count)->to(Navbar::class);
        LivewireAlert::title('Product added to cart successfully!')
            ->success()
            ->show();
    }


    public function render()
    {
        return view('livewire.product-detail-page', [
            'product' => Product::where('slug', $this->slug)->firstOrFail()
        ]);
    }
}
