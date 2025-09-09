<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <section class="flex items-center font-poppins dark:bg-gray-800">
        <div
            class="flex-1 max-w-6xl px-6 py-6 mx-auto bg-white border rounded-lg shadow-md dark:border-gray-900 dark:bg-gray-900 md:py-10 md:px-10">

            <!-- Success Title -->
            <h1 class="px-4 mb-8 text-2xl font-bold tracking-wide text-gray-700 dark:text-gray-300">
                🎉 Thank you! Your order has been received.
            </h1>

            <!-- Address Info -->
            <div class="flex border-b border-gray-200 dark:border-gray-700 w-full h-full px-4 mb-8">
                <div class="flex items-start space-x-4">
                    <div class="flex flex-col space-y-2">
                        <p class="text-lg font-semibold text-gray-800 dark:text-gray-400">
                            {{ $order->address->full_name }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $order->address->street_address }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            {{ $order->address->city }}, {{ $order->address->state }}, {{ $order->address->zip_code }}
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            📞 Phone: {{ $order->address->phone }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <div class="flex flex-wrap items-center pb-4 mb-10 border-b border-gray-200 dark:border-gray-700">
                <div class="w-full px-4 mb-4 md:w-1/4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Order Number</p>
                    <p class="text-base font-semibold text-gray-800 dark:text-gray-300">#{{ $order->id }}</p>
                </div>
                <div class="w-full px-4 mb-4 md:w-1/4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Date</p>
                    <p class="text-base font-semibold text-gray-800 dark:text-gray-300">
                        {{ $order->created_at->format('M d, Y') }}
                    </p>
                </div>
                <div class="w-full px-4 mb-4 md:w-1/4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Total</p>
                    <p class="text-base font-semibold text-blue-600">
                        {{ Number::currency($order->grand_total, 'USD') }}
                    </p>
                </div>
                <div class="w-full px-4 mb-4 md:w-1/4">
                    <p class="text-sm text-gray-600 dark:text-gray-400">Payment Method</p>
                    <p class="text-base font-semibold text-gray-800 dark:text-gray-300">
                        {{ ucfirst($order->payment_method) }}
                    </p>
                </div>
            </div>

            <!-- Order Details -->
            <div class="px-4 mb-10">
                <div class="flex flex-col md:flex-row md:space-x-8">

                    <!-- Left side -->
                    <div class="flex flex-col w-full space-y-6">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">🧾 Order Details</h2>

                        <div class="flex flex-col w-full space-y-3 border-b pb-4 dark:border-gray-700">
                            <div class="flex justify-between">
                                <p class="text-gray-800 dark:text-gray-400">Subtotal</p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ Number::currency($order->grand_total, 'USD') }}
                                </p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-gray-800 dark:text-gray-400">Discount</p>
                                <p class="text-gray-600 dark:text-gray-400">—</p>
                            </div>
                            <div class="flex justify-between">
                                <p class="text-gray-800 dark:text-gray-400">Shipping</p>
                                <p class="text-gray-600 dark:text-gray-400">
                                    {{ Number::currency($order->shipping_amount, 'USD') }}
                                </p>
                            </div>
                        </div>

                        <div class="flex justify-between font-semibold">
                            <p class="text-gray-800 dark:text-gray-300">Total</p>
                            <p class="text-blue-600">
                                {{ Number::currency($order->grand_total + $order->shipping_amount, 'USD') }}
                            </p>
                        </div>
                    </div>

                    <!-- Right side -->
                    <div class="flex flex-col w-full px-2 space-y-4 md:px-8">
                        <h2 class="text-xl font-semibold text-gray-700 dark:text-gray-300">🚚 Shipping</h2>
                        <div class="flex justify-between items-center">
                            <div class="flex items-center space-x-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600 dark:text-blue-400"
                                    fill="currentColor" viewBox="0 0 16 16">
                                    <path
                                        d="M0 3.5A1.5 1.5 0 0 1 1.5 2h9A1.5 1.5 0 0 1 12 3.5V5h1.02a1.5 1.5 0 0 1 1.17.563l1.481 1.85a1.5 1.5 0 0 1 .329.938V10.5a1.5 1.5 0 0 1-1.5 1.5H14a2 2 0 1 1-4 0H5a2 2 0 1 1-3.998-.085A1.5 1.5 0 0 1 0 10.5v-7z" />
                                </svg>
                                <div>
                                    <p class="text-lg font-semibold text-gray-800 dark:text-gray-300">
                                        Standard Delivery
                                    </p>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Delivery within 24 hours</p>
                                </div>
                            </div>
                            <p class="text-lg font-semibold text-gray-800 dark:text-gray-300">
                                {{ Number::currency($order->shipping_amount, 'USD') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-start gap-4 px-4 mt-6">
                <a href="/products"
                    class="w-full md:w-auto px-4 py-2 text-center text-blue-500 border border-blue-500 rounded-md hover:bg-blue-600 hover:text-white dark:border-gray-700 dark:text-gray-300 dark:hover:bg-gray-700">
                    Continue Shopping
                </a>
                <a href="/my-orders"
                    class="w-full md:w-auto px-4 py-2 text-center bg-blue-500 text-white rounded-md hover:bg-blue-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700">
                    View My Orders
                </a>
            </div>
        </div>
    </section>
</div>
