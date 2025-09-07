<?php

namespace App\Livewire;

use App\Helpers\CartMangement;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart - Hope Store')]
class CartPage extends Component
{

    public $cart_items = [];
    public $grand_total = 0;

    public function mount()
    {
        $this->cart_items = CartMangement::getCartItemsFromCookie();
        $this->grand_total = CartMangement::calculateGrandTotal($this->cart_items);
    }

    public function removeItem($product_id)
    {
        $this->cart_items = CartMangement::removeItem($product_id);

        // رجّع العناصر مثل ما هي
        $grandTotal = CartMangement::calculateGrandTotal($this->cart_items);

        // خزّن المجموع في متغير مستقل أو property ثانية
        $this->grand_total = $grandTotal;

        // هنا عد العناصر بشكل صحيح
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))
            ->to(Navbar::class);
    }
    public function increaseQty($product_id)
    {
        $this->cart_items = CartMangement::incrementItemQuantityToCart($product_id);
        $this->grand_total = CartMangement::calculateGrandTotal($this->cart_items);
        // تحديث عداد السلة
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))
            ->to(Navbar::class);
    }

    public function decreaseQty($product_id)
    {
        $this->cart_items = CartMangement::decrementItemQuantityToCart($product_id);
        $this->grand_total = CartMangement::calculateGrandTotal($this->cart_items);
        // تحديث عداد السلة
        $this->dispatch('update-cart-count', total_count: count($this->cart_items))
            ->to(Navbar::class);
    }


    public function render()
    {
        return view('livewire.cart-page');
    }
}
