<div class="max-w-7xl mx-auto py-6">

    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">My Projects</h1>
            <p class="text-gray-500 text-sm mt-1">Manage and track all your assigned projects.</p>
        </div>
        <div class="relative w-full md:w-64">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>
            <input wire:model.live.debounce.300ms="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm dark:bg-gray-800 dark:border-gray-700 dark:text-gray-100" placeholder="Search projects...">
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects as $project)
            @php $myMembership = $project->members->first(); @endphp
            
            <a href="{{ route('member.project.show', $project->id) }}" wire:navigate class="block bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-md transition-shadow duration-200 overflow-hidden group">
                <div class="p-6">
                    <div class="flex justify-between items-start mb-4">
                        <div class="p-2 bg-indigo-50 dark:bg-indigo-900/20 rounded-lg text-indigo-600 dark:text-indigo-400">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $project->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 'bg-gray-100 text-gray-800' }}">
                            {{ ucfirst($project->status) }}
                        </span>
                    </div>

                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-1 group-hover:text-indigo-600 transition-colors">
                        {{ $project->name }}
                    </h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $project->client_name ?? 'Internal Project' }}</p>

                    <div class="border-t border-gray-100 dark:border-gray-700 pt-4 mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">My Role</p>
                            <p class="text-sm font-medium text-gray-700 dark:text-gray-200">{{ ucfirst($myMembership->role) }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] uppercase text-gray-400 font-bold tracking-wider">Share</p>
                            <p class="text-sm font-bold text-indigo-600 dark:text-indigo-400">{{ $myMembership->contribution_share }}%</p>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700/30 px-6 py-3 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center">
                    <span class="text-xs text-gray-500">Platform: {{ $project->platform }}</span>
                    <span class="text-xs font-medium text-indigo-600 group-hover:translate-x-1 transition-transform flex items-center">
                        View Details &rarr;
                    </span>
                </div>
            </a>
        @empty
            <div class="col-span-full py-12 text-center bg-white dark:bg-gray-800 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No projects found</h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">You haven't been assigned to any projects yet.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $projects->links() }}
    </div>
</div>