<div class="max-w-6xl mx-auto space-y-6">

    <form wire:submit.prevent="updateSettings">
        
        <div class="flex items-center justify-between mb-6">
            <div>
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white">System Configuration</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Manage global percentage splits and financial rules.</p>
            </div>
            @can('edit settings')
            <button type="submit" wire:loading.attr="disabled" class="hidden sm:inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 disabled:opacity-50 disabled:cursor-wait text-white text-sm font-medium rounded-xl shadow-lg hover:shadow-indigo-500/30 transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                <svg wire:loading wire:target="updateSettings" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <svg wire:loading.remove wire:target="updateSettings" class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                <span wire:loading.remove wire:target="updateSettings">Save Changes</span>
                <span wire:loading wire:target="updateSettings">Saving...</span>
            </button>
            @else
                <span class="text-sm text-gray-400 italic">Read Only Access</span>
            @endcan
        </div>

        @if (session()->has('message'))
            <div x-data="{ show: true }" x-show="show" class="mb-6 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-800 text-green-700 dark:text-green-300 px-4 py-3 rounded-xl flex items-center justify-between shadow-sm animate-fade-in-down">
                <div class="flex items-center">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    <span>{{ session('message') }}</span>
                </div>
                <button type="button" @click="show = false" class="text-green-500 hover:text-green-700"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <div class="lg:col-span-1 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-indigo-50 dark:bg-indigo-900/20 rounded-full blur-xl opacity-50"></div>
                
                <div class="flex items-center mb-4">
                    <div class="p-2 bg-indigo-100 dark:bg-indigo-900 text-indigo-600 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Primary Backup</h3>
                </div>
                
                <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
                    Deducted from <strong>Gross Total</strong> before distribution.
                </p>

                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Reserve Percentage</label>
                <div class="relative rounded-md shadow-sm">
                    <input type="number" step="0.01" 
                        wire:model.blur="backup_percentage" 
                        value="{{ $backup_percentage }}"
                        class="block w-full pr-10 pl-4 py-3 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 sm:text-lg font-bold text-gray-800 dark:bg-gray-700 dark:text-white transition-colors" placeholder="10">
                    <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                        <span class="text-gray-400 font-medium">%</span>
                    </div>
                </div>
                @error('backup_percentage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
            </div>

            <div class="lg:col-span-2 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6 relative">
                <div class="flex items-center mb-6">
                    <div class="p-2 bg-blue-100 dark:bg-blue-900 text-blue-600 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Standard Role Distribution</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Default shares applied to active team members.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="flex justify-between text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">
                            <span>Bidder Share</span>
                            <span class="text-indigo-500">Brings Project</span>
                        </label>
                        <div class="relative rounded-md shadow-sm group-focus-within:ring-2 ring-indigo-500">
                            <input type="number" step="0.01" 
                                wire:model.blur="default_bidder_percentage" 
                                value="{{ $default_bidder_percentage }}"
                                class="block w-full pr-10 pl-4 py-3 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-blue-500 focus:border-blue-500 sm:text-lg font-medium text-gray-800 dark:bg-gray-700 dark:text-white">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-400">%</span>
                            </div>
                        </div>
                        @error('default_bidder_percentage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="flex justify-between text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">
                            <span>Developer Share</span>
                            <span class="text-green-500">Executes Work</span>
                        </label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" step="0.01" 
                                wire:model.blur="default_developer_percentage" 
                                value="{{ $default_developer_percentage }}"
                                class="block w-full pr-10 pl-4 py-3 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-green-500 focus:border-green-500 sm:text-lg font-medium text-gray-800 dark:bg-gray-700 dark:text-white">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-400">%</span>
                            </div>
                        </div>
                        @error('default_developer_percentage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="lg:col-span-3 bg-white dark:bg-gray-800 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 p-6">
                <div class="flex items-center mb-6">
                     <div class="p-2 bg-purple-100 dark:bg-purple-900 text-purple-600 rounded-lg mr-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Special Scenarios</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Rules for when a single person handles multiple roles.</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Solo Developer (All-in-One)</label>
                        <div class="relative rounded-md shadow-sm">
                            <input type="number" step="0.01" 
                                wire:model.blur="solo_developer_percentage" 
                                value="{{ $solo_developer_percentage }}"
                                class="block w-full pr-10 pl-4 py-3 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-purple-500 focus:border-purple-500 sm:text-lg font-medium text-gray-800 dark:bg-gray-700 dark:text-white">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-400">%</span>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-400">Applied when the Bidder is also the Main Developer.</p>
                        @error('solo_developer_percentage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-400 uppercase tracking-wider mb-2">Idle Partner Share</label>
                        <div class="relative rounded-md shadow-sm">
                             <input type="number" step="0.01" 
                                wire:model.blur="default_idle_percentage" 
                                value="{{ $default_idle_percentage }}"
                                class="block w-full pr-10 pl-4 py-3 border-gray-200 dark:border-gray-600 rounded-xl focus:ring-purple-500 focus:border-purple-500 sm:text-lg font-medium text-gray-800 dark:bg-gray-700 dark:text-white">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none">
                                <span class="text-gray-400">%</span>
                            </div>
                        </div>
                        <p class="mt-2 text-xs text-gray-400">Small retainer for partners not active on the project.</p>
                        @error('default_idle_percentage') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>
            </div>

            <div class="lg:hidden col-span-1 pt-4">
                <button type="submit" wire:loading.attr="disabled" class="w-full flex justify-center py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50">
                    <span wire:loading.remove wire:target="updateSettings">Save Changes</span>
                    <span wire:loading wire:target="updateSettings">Saving...</span>
                </button>
            </div>

        </div> </form> </div>