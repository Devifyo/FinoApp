<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700/50">
                <tr>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Project</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Gross</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Backup (10%)</th>
                    <th class="px-6 py-4 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Net Distributable</th>
                    <th class="px-6 py-4 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($earnings as $earning)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 font-medium">
                        {{ \Carbon\Carbon::parse($earning->earning_date)->format('M d, Y') }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-200">
                            {{ $earning->project->name }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-gray-900 dark:text-white">
                        ${{ number_format($earning->total_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-orange-600 font-medium">
                        ${{ number_format($earning->backup_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-bold text-green-600">
                        ${{ number_format($earning->distributable_amount, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-center">
                        <button wire:click="toggleDetails({{ $earning->id }})" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium focus:outline-none transition-colors border border-indigo-100 hover:bg-indigo-50 rounded-lg px-3 py-1">
                            {{ $viewingEarningId === $earning->id ? 'Close' : 'View Payouts' }}
                        </button>
                    </td>
                </tr>

                @if($viewingEarningId === $earning->id)
                    @include('livewire.admin.earnings.table-details-row')
                @endif

                @empty
                <tr>
                    <td colspan="6" class="px-6 py-20 text-center">
                        <div class="mx-auto h-12 w-12 text-gray-300">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No earnings found</h3>
                        <p class="mt-1 text-sm text-gray-500">Get started by recording a new project earning.</p>
                        <div class="mt-6">
                            @can('manage payouts')
                                <button wire:click="openModal" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    Record Earning
                                </button>
                            @endcan
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">
    {{ $earnings->links() }}
</div>