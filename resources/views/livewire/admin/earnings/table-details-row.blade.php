<tr class="bg-gray-50 dark:bg-gray-900/40 border-t border-b border-gray-100 dark:border-gray-700">
    <td colspan="6" class="px-6 py-6">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                <div class="flex items-center justify-between mb-3">
                    <h4 class="text-xs font-bold text-gray-500 uppercase tracking-wide">Payout Breakdown</h4>
                    <span class="text-xs text-gray-400">Recorded {{ $earning->created_at->diffForHumans() }}</span>
                </div>
                <ul class="space-y-3">
                    @foreach($earning->payouts as $payout)
                    <li wire:key="payout-{{ $payout->id }}" class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 bg-white dark:bg-gray-800 p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm transition-all hover:shadow-md hover:border-indigo-100">
                        
                        <div class="flex items-center">
                            <div class="relative">
                                <div class="h-10 w-10 rounded-full bg-indigo-50 dark:bg-indigo-900/50 flex items-center justify-center text-indigo-700 dark:text-indigo-300 text-sm font-bold mr-3 border border-indigo-100 dark:border-indigo-700 shadow-sm">
                                    {{ substr($payout->user->name, 0, 1) }}
                                </div>
                                @if($payout->is_paid)
                                    <div class="absolute -bottom-1 -right-1 bg-green-500 border-2 border-white dark:border-gray-800 rounded-full w-4 h-4 flex items-center justify-center shadow-sm">
                                        <svg class="w-2.5 h-2.5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                    </div>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-bold text-gray-900 dark:text-white">{{ $payout->user->name }}</div>
                                <div class="text-xs text-gray-500 flex items-center gap-2">
                                    <span class="bg-gray-100 dark:bg-gray-700 px-2 py-0.5 rounded text-[10px] font-medium text-gray-600 dark:text-gray-300 uppercase tracking-wide border border-gray-200 dark:border-gray-600">
                                        {{ ucfirst($payout->role_at_time) }}
                                    </span>
                                    <span>{{ $payout->percentage_applied }}% Share</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-col items-end justify-center w-full sm:w-auto mt-2 sm:mt-0 pl-14 sm:pl-0">
                            <div class="flex items-center justify-end gap-4 mb-1">
                                <span class="text-sm font-bold text-gray-900 dark:text-white">
                                    ${{ number_format($payout->amount, 2) }}
                                </span>
                                @can('manage payouts')
                                    <button 
                                        wire:click="togglePayoutStatus({{ $payout->id }})" 
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all border shadow-sm
                                        {{ $payout->is_paid 
                                            ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800' 
                                            : 'bg-white text-gray-600 border-gray-200 hover:bg-gray-50 hover:text-gray-900 dark:bg-gray-700 dark:text-gray-300 dark:border-gray-600 dark:hover:bg-gray-600' 
                                        }}"
                                    >
                                        @if($payout->is_paid)
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            Paid
                                        @else
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                            Pay Now
                                        @endif
                                    </button>
                                @else
                                    <span class="px-3 py-1.5 rounded-lg text-xs font-semibold border
                                        {{ $payout->is_paid 
                                            ? 'bg-green-50 text-green-700 border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800' 
                                            : 'bg-gray-50 text-gray-500 border-gray-200 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600' }}">
                                        {{ $payout->is_paid ? 'Paid' : 'Unpaid' }}
                                    </span>
                                @endcan
                            </div>

                            @if($payout->is_paid && $payout->paid_at)
                                <div class="text-[10px] font-medium text-green-600 dark:text-green-400 flex items-center gap-1 animate-fade-in-down">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    Transferred on {{ $payout->paid_at->format('M d, Y') }}
                                </div>
                            @endif
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>
            
            <div class="flex flex-col justify-end items-end border-t lg:border-t-0 lg:border-l border-gray-200 dark:border-gray-700 pt-6 lg:pt-0 lg:pl-8">
                @can('manage payouts')
                    <button wire:click="delete({{ $earning->id }})" wire:confirm="Delete this earning record?" class="text-red-500 hover:text-red-700 hover:bg-red-50 px-3 py-2 rounded-lg text-sm font-medium flex items-center transition-colors w-full lg:w-auto justify-end">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                        Delete Entire Record
                    </button>
                @endcan
            </div>
        </div>
    </td>
</tr>