<div class="max-w-7xl mx-auto py-6">
    
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">Welcome back, {{ auth()->user()->name }}!</h1>
        <p class="text-gray-500 dark:text-gray-400 mt-1">Here is an overview of your earnings and active projects.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">My Total Earnings</p>
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2">
                    ${{ number_format($total_earnings, 2) }}
                </h2>
                <p class="text-xs text-green-600 mt-2 font-medium flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Paid to date
                </p>
            </div>
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-green-50 to-transparent dark:from-green-900/10"></div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-gray-700 relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">Active Projects</p>
                <h2 class="text-4xl font-extrabold text-gray-900 dark:text-white mt-2">
                    {{ $active_projects_count }}
                </h2>
                <p class="text-xs text-indigo-500 mt-2 font-medium">Currently assigned</p>
            </div>
            <div class="absolute right-0 top-0 h-full w-24 bg-gradient-to-l from-indigo-50 to-transparent dark:from-indigo-900/10"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2">
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden flex flex-col h-full">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">My Projects</h3>
                </div>
                
                <div class="divide-y divide-gray-100 dark:divide-gray-700 flex-grow">
                    @forelse($my_projects as $project)
                        @php 
                            $myMembership = $project->members->first(); 
                        @endphp
                        <a href="{{ route('member.project.show', $project->id) }}" wire:navigate class="block p-5 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors cursor-pointer group">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="text-base font-bold text-gray-900 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">
                                        {{ $project->name }} &rarr;
                                    </h4>
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $project->client_name ?? 'Internal' }}</p>
                                </div>
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-medium 
                                    {{ $project->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-800' }}">
                                    {{ ucfirst($project->status) }}
                                </span>
                            </div>
                            
                            <div class="mt-4 flex items-center gap-4 text-sm">
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase text-gray-400 font-bold">My Role</span>
                                    <span class="font-medium text-gray-700 dark:text-gray-200">{{ ucfirst($myMembership->role) }}</span>
                                </div>
                                <div class="w-px h-8 bg-gray-200 dark:bg-gray-600"></div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase text-gray-400 font-bold">My Share</span>
                                    <span class="font-medium text-indigo-600 dark:text-indigo-400">{{ $myMembership->contribution_share }}%</span>
                                </div>
                                <div class="w-px h-8 bg-gray-200 dark:bg-gray-600"></div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] uppercase text-gray-400 font-bold">Platform</span>
                                    <span class="font-medium text-gray-700 dark:text-gray-200">{{ $project->platform }}</span>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-gray-500">
                            You are not assigned to any projects yet.
                        </div>
                    @endforelse
                </div>

                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    {{ $my_projects->links() }}
                </div>
                </div>
        </div>

        <div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden sticky top-6">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-800/50">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wide">Recent Payouts</h3>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse($recent_payouts as $payout)
                    <div class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                +${{ number_format($payout->amount, 2) }}
                            </p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate max-w-[150px]">
                                {{ $payout->earning->project->name ?? 'Unknown Project' }}
                            </p>
                        </div>
                        <div class="text-right">
                            <span class="text-[10px] font-medium text-gray-400 block">
                                {{ \Carbon\Carbon::parse($payout->paid_at)->format('M d') }}
                            </span>
                            <span class="inline-flex items-center px-1.5 py-0.5 rounded text-[10px] font-medium bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                                Paid
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="p-6 text-center">
                        <div class="mx-auto h-10 w-10 text-gray-300 mb-2">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <p class="text-xs text-gray-500">No payouts received yet.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>
</div>