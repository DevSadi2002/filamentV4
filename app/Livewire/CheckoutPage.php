<?php

namespace App\Livewire;

use App\Helpers\CartMangement;
use App\Mail\OrderPLaced;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Stripe;

#[Title('Checkout')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $street_address;
    public $city;
    public $state;
    public $zip_code;
    public $payment_method;




    public function placeOrder()
    {
        // ✅ التحقق من صحة البيانات المدخلة
        $this->validate([
            'first_name'      => 'required|string|max:100',
            'last_name'       => 'required|string|max:100',
            'phone'           => 'required|string|max:20',
            'street_address'  => 'required|string|max:255',
            'city'            => 'required|string|max:100',
            'state'           => 'required|string|max:100',
            'zip_code'        => 'required|string|max:20',
            'payment_method'  => 'required|in:cash,stripe',
        ]);

        // ✅ جلب المنتجات من السلة
        $cart_items = CartMangement::getCartItemsFromCookie();

        if (empty($cart_items)) {
            return back()->with('error', 'Cart is empty, please add items before checkout.');
        }

        // ✅ تجهيز line_items لـ Stripe
        $line_items = [];
        foreach ($cart_items as $item) {
            $line_items[] = [
                'price_data' => [
                    'currency'     => 'usd',
                    'unit_amount'  => $item['unit_amount'] * 100, // Stripe يقبل بالسنت
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }

        // ✅ إنشاء الطلب
        $order = new Order();
        $order->user_id        = Auth::id();
        $order->grand_total    = CartMangement::calculateGrandTotal($cart_items);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status         = 'new';
        $order->currency       = 'usd';
        $order->shipping_amount = 0;
        $order->shipping_method = 'none';
        $order->notes          = 'Order placed by ' . Auth::user()->name;
        $order->save();

        // ✅ حفظ العنوان المرتبط بالطلب
        $address = new Address();
        $address->order_id      = $order->id; // ← التعديل الأساسي
        $address->first_name    = $this->first_name;
        $address->last_name     = $this->last_name;
        $address->phone         = $this->phone;
        $address->street_address = $this->street_address;
        $address->city          = $this->city;
        $address->state         = $this->state;
        $address->zip_code      = $this->zip_code;
        $address->save();

        // ✅ إضافة العناصر للطلب (علاقة hasMany)
        $order->items()->createMany($cart_items);

        // ✅ إعداد redirect URL
        $redirect_url = '';

        if ($this->payment_method === 'stripe') {
            // Stripe API key
            Stripe::setApiKey(env('STRIPE_SECRET'));

            // ✅ إنشاء جلسة Checkout في Stripe
            $sessionCheckout  = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'customer_email'       => Auth::user()->email,
                'line_items'           => $line_items,
                'mode'                 => 'payment',
                'success_url'          => route('seccess') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'           => route('cancel'),
            ]);

            $redirect_url = $sessionCheckout->url;
        } else {
            // الدفع عند الاستلام (Cash on Delivery)
            $redirect_url = route('seccess');
        }

        // ✅ تفريغ السلة بعد إنشاء الطلب
        CartMangement::clearCart();

        // ✅ تفريغ السلة بعد إنشاء الطلب
        Mail::to(request()->user())->send(new OrderPlaced($order));
        // ✅ إعادة التوجيه لصفحة Stripe أو Success
        return redirect($redirect_url);
    }


    public function render()
    {
        $cart_items = CartMangement::getCartItemsFromCookie();
        $grand_total = CartMangement::calculateGrandTotal($cart_items);
        return view('livewire.checkout-page', [
            'cart_items' => $cart_items,
            'grand_total' => $grand_total
        ]);
    }
}
