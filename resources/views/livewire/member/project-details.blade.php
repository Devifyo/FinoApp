<div class="max-w-7xl mx-auto py-6">
    
    <div class="mb-6">
        <a href="{{ route('member.dashboard') }}" wire:navigate class="flex items-center text-sm text-gray-500 hover:text-indigo-600 transition-colors">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Back to Dashboard
        </a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm p-6 border border-gray-100 dark:border-gray-700">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white">{{ $project->name }}</h1>
                    <p class="text-gray-500 dark:text-gray-400 mt-1">{{ $project->client_name ?? 'Internal Project' }}</p>
                </div>
                <span class="px-3 py-1 rounded-full text-sm font-medium 
                    {{ $project->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                    {{ ucfirst($project->status) }}
                </span>
            </div>
            
            <div class="mt-6 grid grid-cols-2 gap-4">
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <p class="text-xs uppercase text-gray-500 font-bold">Platform</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $project->platform }}</p>
                </div>
                <div class="p-4 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                    <p class="text-xs uppercase text-gray-500 font-bold">Start Date</p>
                    <p class="text-lg font-semibold text-gray-900 dark:text-white">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('M d, Y') : 'N/A' }}</p>
                </div>
            </div>
        </div>

        <div class="bg-indigo-600 rounded-2xl shadow-lg p-6 text-white relative overflow-hidden">
            <div class="relative z-10">
                <p class="text-indigo-100 font-medium text-sm uppercase">My Earnings from this Project</p>
                <h2 class="text-4xl font-extrabold mt-2">${{ number_format($my_earnings, 2) }}</h2>
                <p class="text-xs text-indigo-200 mt-2">Total paid out to me</p>
            </div>
            <div class="absolute -right-6 -top-6 w-32 h-32 bg-white opacity-10 rounded-full"></div>
            <div class="absolute -right-2 -bottom-10 w-24 h-24 bg-white opacity-10 rounded-full"></div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">Team Members</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($team as $member)
                <div class="p-4 flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="h-10 w-10 rounded-full bg-gray-200 dark:bg-gray-700 flex items-center justify-center text-gray-500 font-bold text-sm">
                            {{ substr($member->user->name, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-sm font-bold text-gray-900 dark:text-white">
                                {{ $member->user->name }}
                                @if($member->user->id === auth()->id())
                                    <span class="ml-2 text-[10px] bg-indigo-100 text-indigo-700 px-1.5 py-0.5 rounded">You</span>
                                @endif
                            </p>
                            <p class="text-xs text-gray-500">{{ $member->user->email }}</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <span class="block text-sm font-medium text-gray-900 dark:text-white">{{ ucfirst($member->role) }}</span>
                        @if($member->user->id === auth()->id())
                            <span class="text-xs text-indigo-600 font-bold">{{ $member->contribution_share }}% Share</span>
                        @endif
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">My Payout History</h3>
            </div>
            <div class="divide-y divide-gray-100 dark:divide-gray-700">
                @forelse($payouts as $payout)
                <div class="p-4 flex items-center justify-between hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                    <div>
                        <p class="text-sm font-bold text-green-600 dark:text-green-400">
                            +${{ number_format($payout->amount, 2) }}
                        </p>
                        <p class="text-xs text-gray-400">
                            Date: {{ \Carbon\Carbon::parse($payout->paid_at)->format('M d, Y') }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-50 text-green-700 dark:bg-green-900/20 dark:text-green-300">
                            Paid
                        </span>
                    </div>
                </div>
                @empty
                <div class="p-8 text-center text-gray-400 text-sm">
                    No payouts received for this project yet.
                </div>
                @endforelse
            </div>
        </div>

    </div>
</div>