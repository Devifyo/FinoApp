<div class="max-w-7xl mx-auto relative min-h-screen pb-20" 
     x-data="{ 
        toast: false, 
        message: '', 
        type: 'success',
        showToast(msg, t = 'success') {
            this.message = msg;
            this.type = t;
            this.toast = true;
            setTimeout(() => this.toast = false, 3000);
        }
     }"
     @notify.window="showToast($event.detail.message, $event.detail.type || 'success')"
>
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Active Projects</h1>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Track current development contracts and team allocations.</p>
        </div>
        @can('create projects')
            <button wire:click="openModal" class="group inline-flex items-center justify-center px-5 py-2.5 text-sm font-semibold text-white transition-all duration-200 bg-indigo-600 border border-transparent rounded-xl shadow-md hover:bg-indigo-700 hover:shadow-lg hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-600">
                <svg class="w-5 h-5 mr-2 -ml-1 transition-transform group-hover:rotate-90" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                New Project
            </button>
        @endcan
    </div>

    @if($projects->isEmpty())
        <div class="text-center py-20 bg-white dark:bg-gray-800 rounded-3xl border-2 border-dashed border-gray-200 dark:border-gray-700">
            <div class="bg-indigo-50 dark:bg-indigo-900/30 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            </div>
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">No projects found</h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Get started by creating your first project contract.</p>
            @can('create projects')
                <button wire:click="openModal" class="mt-6 text-indigo-600 hover:text-indigo-500 font-medium">Create Project &rarr;</button>
            @endcan
        </div>
    @else
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
       @foreach($projects as $project)
            <div class="group relative flex flex-col h-full bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden">
                
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex justify-between items-start mb-4">
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                            {{ $project->status === 'active' ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300' : 
                            ($project->status === 'completed' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900/30 dark:text-blue-300' : 
                            'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/30 dark:text-yellow-300') }}">
                            <span class="w-1.5 h-1.5 rounded-full mr-1.5 
                                {{ $project->status === 'active' ? 'bg-green-500' : 
                                ($project->status === 'completed' ? 'bg-blue-500' : 'bg-yellow-500') }}"></span>
                            {{ ucfirst($project->status) }}
                        </span>
                        
                        <div class="flex items-center space-x-1 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            @can('edit projects')
                                <button wire:click="edit({{ $project->id }})" class="p-1.5 text-gray-400 hover:text-indigo-600 bg-gray-50 hover:bg-indigo-50 rounded-lg transition-colors" title="Edit">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                </button>
                            @endcan
                            @can('delete projects')
                                <button wire:click="confirmDelete({{ $project->id }})" class="p-1.5 text-gray-400 hover:text-red-600 bg-gray-50 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            @endcan
                        </div>
                    </div>

                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1 group-hover:text-indigo-600 transition-colors">
                        {{ $project->name }}
                    </h3>
                    <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-6">
                        <svg class="w-4 h-4 mr-1.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ $project->client_name ?? 'Internal Project' }}
                    </div>

                    <div class="mt-auto"> <div class="relative overflow-hidden rounded-xl bg-gradient-to-br from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 border border-emerald-100 dark:border-emerald-800/30 p-4 group-hover:border-emerald-200 transition-colors">
                            <div class="flex items-center justify-between relative z-10">
                                <div>
                                    <p class="text-[10px] font-bold uppercase tracking-wider text-emerald-600 dark:text-emerald-400 mb-0.5">
                                        Total Revenue
                                    </p>
                                    <p class="text-2xl font-extrabold text-gray-900 dark:text-white font-mono tracking-tight">
                                        ${{ number_format($project->earnings_sum_total_amount ?? 0, 2) }}
                                    </p>
                                </div>
                                <div class="h-10 w-10 bg-emerald-100 dark:bg-emerald-800 rounded-lg flex items-center justify-center text-emerald-600 dark:text-emerald-300 shadow-sm">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-emerald-200/20 dark:bg-emerald-500/10 rounded-full blur-xl pointer-events-none"></div>
                        </div>
                    </div>
                </div>

                <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700/30 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex justify-between items-center mb-3">
                        <div class="text-xs font-semibold text-gray-400 uppercase">Team Allocation</div>
                        <span class="text-xs text-gray-400 bg-gray-100 dark:bg-gray-600 px-2 py-0.5 rounded-md">
                            {{ $project->members->count() }} Members
                        </span>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @foreach($project->members as $member)
                            <div class="inline-flex items-center bg-white dark:bg-gray-700 rounded-full pl-1 pr-2.5 py-1 border border-gray-200 dark:border-gray-600 shadow-sm hover:border-gray-300 transition-colors">
                                <img class="h-5 w-5 rounded-full mr-2" src="https://ui-avatars.com/api/?name={{ $member->user->name }}&background=random&size=32" alt=""/>
                                <span class="text-xs font-medium text-gray-700 dark:text-gray-200 mr-1.5 max-w-[80px] truncate">{{ $member->user->name }}</span>
                                <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-md leading-none
                                    {{ $member->role == 'bidder' ? 'bg-blue-50 text-blue-700 dark:bg-blue-900/50 dark:text-blue-300' : 
                                    ($member->role == 'developer' ? 'bg-green-50 text-green-700 dark:bg-green-900/50 dark:text-green-300' : 'bg-gray-100 text-gray-600 dark:bg-gray-600 dark:text-gray-300') }}">
                                    {{ (float)$member->contribution_share }}%
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-10">
        {{ $projects->links() }}
    </div>
    @endif

    @include('livewire.admin.projects.form-modal')
    @include('livewire.admin.projects.delete-modal')

    <div 
        x-show="toast" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-100"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed bottom-5 right-5 z-50 max-w-sm w-full bg-white dark:bg-gray-800 shadow-lg rounded-xl pointer-events-auto ring-1 ring-black ring-opacity-5 overflow-hidden" 
        style="display: none;"
    >
        <div class="p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg x-show="type === 'success'" class="h-6 w-6 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <svg x-show="type === 'error'" class="h-6 w-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-medium text-gray-900 dark:text-white" x-text="type === 'success' ? 'Success' : 'Error'"></p>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400" x-text="message"></p>
                </div>
                <div class="ml-4 flex-shrink-0 flex">
                    <button @click="toast = false" class="bg-white dark:bg-gray-800 rounded-md inline-flex text-gray-400 hover:text-gray-500 focus:outline-none">
                        <span class="sr-only">Close</span>
                        <svg class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>