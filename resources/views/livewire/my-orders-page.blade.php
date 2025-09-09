<div wire:poll class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <h1 class="text-4xl font-extrabold text-slate-700 dark:text-slate-300 mb-6">🛒 My Orders</h1>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-xl shadow-lg border dark:border-slate-700">
        <div class="-m-1.5 overflow-x-auto">
            <div class="p-1.5 min-w-full inline-block align-middle">
                <div class="overflow-hidden rounded-lg border border-gray-200 dark:border-slate-700">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-slate-700">
                        <thead class="bg-slate-100 dark:bg-slate-800">
                            <tr>
                                <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Order</th>
                                <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Date</th>
                                <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Status</th>
                                <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Payment</th>
                                <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Amount</th>
                                <th class="px-6 py-3 text-end text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">

                            @foreach ($orders as $order)
                                @php
                                    // Badge for Order Status
                                    $statusBadge = match ($order->status) {
                                        'new'
                                            => '<span class="inline-flex items-center bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs font-semibold">New</span>',
                                        'processing'
                                            => '<span class="inline-flex items-center bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs font-semibold">Processing</span>',
                                        'shipped'
                                            => '<span class="inline-flex items-center bg-purple-100 text-purple-700 px-3 py-1 rounded-full text-xs font-semibold">Shipped</span>',
                                        'deliverd'
                                            => '<span class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Delivered</span>',
                                        'canceled'
                                            => '<span class="inline-flex items-center bg-red-100 text-red-700 px-3 py-1 rounded-full text-xs font-semibold">Canceled</span>',
                                        default
                                            => '<span class="inline-flex items-center bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs font-semibold">Unknown</span>',
                                    };

                                    // Badge for Payment Status
                                    $paymentBadge =
                                        $order->payment_status === 'paid'
                                            ? '<span class="inline-flex items-center bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">Paid</span>'
                                            : '<span class="inline-flex items-center bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">Pending</span>';
                                @endphp

                                <tr wire:key="{{ $order->id }}"
                                    class="hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                    <td class="px-6 py-4 text-sm font-medium text-slate-800 dark:text-slate-200">
                                        #{{ $order->id }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                                        {{ $order->created_at->format('d M Y') }}
                                    </td>
                                    {{-- @dump( $order->status ) --}}
                                    <td class="px-6 py-4 text-sm">{{ $order->status }}</td>
                                    <td class="px-6 py-4 text-sm">{!! $paymentBadge !!}</td>
                                    <td class="px-6 py-4 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                        ${{ number_format($order->grand_total, 2) }}
                                    </td>
                                    <td wire:key="{{ $order->id }}" class="px-6 py-4 text-end">
                                        <a wire:key="{{ $order->id }}"
                                            href="{{ route('my-orders.details', $order->id) }}"
                                            class="inline-flex items-center gap-2 bg-slate-600 text-white text-sm px-4 py-2 rounded-lg shadow hover:bg-slate-500 transition">
                                            View Details
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                                viewBox="0 0 16 16">
                                                <path
                                                    d="M1 8a7 7 0 1114 0A7 7 0 011 8zm7-4a1 1 0 100 2 1 1 0 000-2zm0 3a.5.5 0 00-.5.5v3a.5.5 0 001 0v-3A.5.5 0 008 7z" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach

                        </tbody>
                    </table>

                    <!-- If no orders -->
                    @if ($orders->isEmpty())
                        <div class="text-center py-6 text-slate-500 dark:text-slate-400">
                            No orders found.
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
