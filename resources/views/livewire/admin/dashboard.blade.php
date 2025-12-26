<div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Earnings</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">${{ number_format($totalEarnings, 2) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 bg-indigo-100 text-indigo-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Active Projects</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $activeProjects }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Team Members</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">{{ $totalMembers }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm p-5 border border-gray-100 dark:border-gray-700">
            <div class="flex items-center">
                <div class="flex-shrink-0 h-12 w-12 bg-yellow-100 text-yellow-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <div class="ml-4">
                    <h2 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Backup (10%)</h2>
                    <p class="text-2xl font-bold text-gray-800 dark:text-white">${{ number_format($totalEarnings * 0.10, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-xl border border-gray-100 dark:border-gray-700">
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex justify-between items-center">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white">Recent Activities</h3>
            <a href="{{ route('admin.earnings') }}" wire:navigate class="text-sm font-medium text-indigo-600 hover:text-indigo-500 dark:text-indigo-400">
                View All
            </a>
        </div>
        
        <div class="p-4">
            @forelse($activities as $activity)
                <div class="flex items-center justify-between p-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 rounded-lg transition-colors border-b border-gray-50 dark:border-gray-700 last:border-0">
                    
                    <div class="flex items-center space-x-4">
                        @if($activity->type === 'earning')
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center text-green-600 dark:text-green-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Payment Received</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    {{ $activity->project->name ?? 'Unknown Project' }}
                                </p>
                            </div>
                        @else
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-orange-100 dark:bg-orange-900/30 flex items-center justify-center text-orange-600 dark:text-orange-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-bold text-gray-900 dark:text-white">Payout Sent</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    To {{ $activity->user->name ?? 'Unknown User' }}
                                    <span class="mx-1 text-gray-300 dark:text-gray-600">&bull;</span>
                                    <span class="text-indigo-500 dark:text-indigo-400 font-medium">
                                        {{ $activity->earning->project->name ?? 'Project Deleted' }}
                                    </span>
                                </p>
                            </div>
                        @endif
                    </div>

                    <div class="text-right">
                        @if($activity->type === 'earning')
                            <p class="text-sm font-bold text-green-600 dark:text-green-400">
                                +${{ number_format($activity->total_amount, 2) }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $activity->created_at->diffForHumans() }}
                            </p>
                        @else
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                -${{ number_format($activity->amount, 2) }}
                            </p>
                            <p class="text-xs text-gray-400">
                                {{ $activity->paid_at ? \Carbon\Carbon::parse($activity->paid_at)->diffForHumans() : 'Just now' }}
                            </p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-8">
                    <div class="mx-auto h-12 w-12 text-gray-300 mb-3">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <p class="text-gray-500 dark:text-gray-400">No recent activity found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>