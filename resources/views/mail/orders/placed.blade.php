<x-mail::message>
    # 🎉 Order Placed Successfully!

    Hello {{ $order->user->name }},

    Thank you for shopping with **{{ config('app.name') }}**.
    We’re excited to let you know that your order has been received and is now being processed.
    Once your package ships, you’ll get another email with the tracking details.

    ---

    **🧾 Order Details:**
    - **Order Number:** #{{ $order->id }}
    - **Total Amount:** ${{ number_format($order->grand_total, 2) }}
    - **Payment Method:** {{ ucfirst($order->payment_method) }}
    - **Status:** {{ ucfirst($order->status) }}

    ---

    <x-mail::button :url="$url">
        View Your Order
    </x-mail::button>

    If you have any questions, just reply to this email — we’re always happy to help.

    Thanks for choosing us!
    Best regards,
    **{{ config('app.name') }}** Team
</x-mail::message>
