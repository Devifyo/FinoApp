<div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
    <div>
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Earnings & Payouts</h1>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Track monthly revenue and manage team payouts.</p>
    </div>
    @can('manage payouts')
        <button wire:click="openModal" class="group inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-indigo-600 border border-transparent rounded-xl shadow-md hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
            <svg class="w-5 h-5 mr-2 -ml-1 transition-transform group-hover:scale-110" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Record Earning
        </button>
    @endcan
</div>