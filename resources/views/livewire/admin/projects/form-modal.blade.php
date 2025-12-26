<x-modal :isOpen="$isModalOpen" title="{{ $isEditMode ? 'Edit Project' : 'Create New Project' }}">
    <form wire:submit.prevent="save">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-6 mb-8">
            
            <div class="md:col-span-6">
                <x-input label="Project Name" wire:model="name" name="name" placeholder="e.g. SaaS Dashboard Redesign" />
            </div>
            
            <div class="md:col-span-6">
                <x-input label="Client" wire:model="client_name" name="client_name" placeholder="e.g. Acme Inc." />
            </div>

            <div class="md:col-span-4">
                <x-select label="Platform" wire:model="platform" name="platform">
                    <option value="">Select Platform...</option>
                    <option value="Upwork">Upwork</option>
                    <option value="Freelancer">Freelancer</option>
                    <option value="Fiverr">Fiverr</option>
                    <option value="Toptal">Toptal</option>
                    <option value="Direct">Direct Client</option>
                    <option value="Other">Other</option>
                </x-select>
            </div>

            <div class="md:col-span-4">
    <x-input 
        label="Start Date" 
        wire:model="start_date" 
        name="start_date" 
        placeholder="Select Start Date..."
        onfocus="this.showPicker()" 
        onclick="this.showPicker()"
        class="cursor-pointer"
        type="{{ $start_date ? 'date' : 'text' }}"
        onfocus="this.type='date'"
        onblur="if(!this.value) this.type='text'"
    />
</div>

            <div class="md:col-span-4">
                <x-select label="Status" wire:model="status" name="status">
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="hold">On Hold</option>
                </x-select>
            </div>
            
        </div>

        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl border border-gray-200 dark:border-gray-700 overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center bg-gray-100/50 dark:bg-gray-700/50">
                <div>
                    <h4 class="text-sm font-bold text-gray-900 dark:text-white">Team Allocation</h4>
                    <p class="text-xs text-gray-500">Assign roles and revenue shares.</p>
                </div>
                <button type="button" wire:click="addMember" class="inline-flex items-center px-3 py-1.5 text-xs font-medium text-indigo-700 bg-indigo-50 border border-indigo-200 rounded-lg hover:bg-indigo-100 transition-colors">
                    + Add Member
                </button>
            </div>
            
            @php $tableInput = "w-full border-none bg-transparent focus:ring-0 text-sm p-0 placeholder-gray-400"; @endphp

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm min-w-[600px]">
                    <thead class="bg-white dark:bg-gray-800 text-xs uppercase text-gray-500 font-semibold border-b border-gray-100 dark:border-gray-700">
                        <tr>
                            <th class="px-5 py-3 w-1/3">User</th>
                            <th class="px-5 py-3">Role</th>
                            <th class="px-5 py-3">Share %</th>
                            <th class="px-5 py-3">Main Dev</th>
                            <th class="px-5 py-3 text-center"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-700 bg-white dark:bg-gray-800">
                        @foreach($assigned_members as $index => $member)
                        <tr wire:key="member-row-{{ $index }}" class="group hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <td class="px-5 py-3">
                                <select wire:model="assigned_members.{{ $index }}.user_id" class="{{ $tableInput }} font-medium text-gray-900 dark:text-gray-100">
                                    <option value="">Select User...</option>
                                    @foreach($users as $u)
                                        <option value="{{ $u->id }}">{{ $u->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="px-5 py-3">
                                <select wire:model.live="assigned_members.{{ $index }}.role" class="{{ $tableInput }} text-gray-600 dark:text-gray-400">
                                    <option value="developer">Developer</option>
                                    <option value="bidder">Bidder</option>
                                    <option value="idle">Idle</option>
                                    <option value="solo">Solo (Both)</option>
                                </select>
                            </td>
                            <td class="px-5 py-3">
                                <div class="flex items-center bg-gray-50 dark:bg-gray-700 rounded-md px-2 py-1 w-24">
                                    <input type="number" 
                                           wire:model="assigned_members.{{ $index }}.contribution_share" 
                                           class="w-full border-none bg-transparent focus:ring-0 text-sm p-0 text-right font-bold text-indigo-600" 
                                           min="0" 
                                           max="100" 
                                           placeholder="0">
                                    <span class="ml-1 text-gray-400 text-xs">%</span>
                                </div>
                            </td>
                            <td class="px-5 py-3">
                                <input type="checkbox" wire:model="assigned_members.{{ $index }}.is_main_developer" class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 h-4 w-4">
                            </td>
                            <td class="px-5 py-3 text-center">
                                <button type="button" wire:click="removeMember({{ $index }})" class="text-gray-300 group-hover:text-red-500 transition-colors p-1 hover:bg-red-50 rounded-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @error('assigned_members') <div class="mt-2 text-red-500 text-xs font-medium">{{ $message }}</div> @enderror

        <button type="submit" class="hidden"></button>
    </form>

    <x-slot name="footer">
        <button type="button" wire:click="save" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 font-semibold text-sm shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5">
            {{ $isEditMode ? 'Save Changes' : 'Create Project' }}
        </button>
        <button type="button" wire:click="closeModal" class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium text-sm transition-colors">
            Cancel
        </button>
    </x-slot>
</x-modal>