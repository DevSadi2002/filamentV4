<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Address;
use Livewire\Attributes\Title;

#[Title('Order Details - Hope Store')]

class MyOrderDetailPage extends Component
{
    public $order_id;

    public function mount($order_id = null)
    {
        $this->order_id = $order_id;
    }

    public function render()
    {
        $order = Order::with(['items.product', 'address', 'user'])->findOrFail($this->order_id);

        $statusColors = [
            'new' => 'bg-blue-500',
            'processing' => 'bg-yellow-500',
            'shipped' => 'bg-indigo-500',
            'delivered' => 'bg-green-500',
            'cancelled' => 'bg-red-500',
        ];

        $paymentColors = [
            'pending' => 'bg-yellow-500',
            'paid' => 'bg-green-500',
            'failed' => 'bg-red-500',
        ];

        return view('livewire.my-order-detail-page', [
            'order' => $order,
            'statusColors' => $statusColors,
            'paymentColors' => $paymentColors,
        ]);
    }
}
