<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('My Orders - Hope Store')]
class MyOrdersPage extends Component
{

    public function render()
    {
        $myOrder = Order::where('user_id', auth()->user()->id)->latest()->paginate(5);
        return view('livewire.my-orders-page', [
            'orders' => $myOrder
        ]);
    }
}
