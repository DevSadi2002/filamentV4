<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
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
                                    Order Status</th>
                                <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Payment</th>
                                <th class="px-6 py-3 text-start text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Amount</th>
                                <th class="px-6 py-3 text-end text-sm font-semibold text-gray-700 dark:text-gray-300">
                                    Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 dark:divide-slate-700">

                            <!-- Example Row -->
                            <tr class=" text-white hover:bg-slate-50 dark:hover:bg-slate-800 transition">
                                <td class="px-6 py-4 text-sm font-medium text-slate-800 dark:text-slate-200">#1020</td>
                                <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">18 Feb 2024</td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex items-center gap-1 bg-orange-100 text-orange-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M8 3.293l6 6V15H2V9.293l6-6zM0 9l8-8 8 8v8a1 1 0 01-1 1H1a1 1 0 01-1-1V9z" />
                                        </svg>
                                        Pending
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm">
                                    <span
                                        class="inline-flex items-center gap-1 bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="currentColor"
                                            viewBox="0 0 16 16">
                                            <path
                                                d="M16 8A8 8 0 11.001 8a8 8 0 0115.999 0zM7 11l5-5-1.5-1.5L7 8.5 5.5 7 4 8.5 7 11z" />
                                        </svg>
                                        Paid
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-sm font-semibold text-slate-800 dark:text-slate-200">
                                    $12,000.00</td>
                                <td class="px-6 py-4 text-end">
                                    <a href="#"
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

                            <!-- More rows dynamically here -->

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
