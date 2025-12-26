<div class="max-w-7xl mx-auto py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Sub-Admins</h2>
        @can('manage sub_admins')
            <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                + Add Sub-Admin
            </button>
        @endcan
    </div>

    <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg overflow-hidden">
        <table class="w-full text-left text-sm">
            <thead class="bg-gray-50 dark:bg-gray-700 text-gray-500 font-semibold">
                <tr>
                    <th class="px-6 py-3">Name</th>
                    <th class="px-6 py-3">Permissions Access</th>
                    <th class="px-6 py-3 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                @foreach($subAdmins as $admin)
                <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                    <td class="px-6 py-4 font-medium text-gray-900 dark:text-white">
                        {{ $admin->name }}<br>
                        <span class="text-xs text-gray-500 font-normal">{{ $admin->email }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-wrap gap-1">
                            @foreach($admin->permissions as $perm)
                                <span class="px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                    {{ $perm->name }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        @can('manage sub_admins')
                            <button wire:click="edit({{ $admin->id }})" class="text-indigo-600 hover:text-indigo-900 font-medium">Edit</button>
                        @else
                            <span class="text-gray-400 cursor-not-allowed">Read Only</span>
                        @endcan
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <x-modal :isOpen="$isModalOpen" title="{{ $sub_admin_id ? 'Edit Sub-Admin' : 'Create Sub-Admin' }}">
        <form wire:submit.prevent="save">
            
            <div class="mb-4">
                <x-input label="Name" wire:model="name" name="name" />
            </div>
            <div class="mb-4">
                <x-input label="Email" wire:model="email" name="email" type="email" />
            </div>
            <div class="mb-4">
                <x-input label="Password" wire:model="password" name="password" type="password" placeholder="{{ $sub_admin_id ? 'Leave blank to keep current' : '' }}" />
            </div>

            <div class="mt-6">
                <label class="block text-sm font-bold text-gray-700 dark:text-gray-300 mb-4">Access Permissions</label>
                
                @php
                    // Logic to group permissions by Category
                    $groupedPermissions = $allPermissions->groupBy(function($item) {
                        $name = $item->name;
                        
                        if (str_contains($name, 'project')) return 'Projects Module';
                        if (str_contains($name, 'user')) return 'User Management';
                        if (str_contains($name, 'earning') || str_contains($name, 'payout')) return 'Earnings & Finance';
                        if (str_contains($name, 'setting')) return 'Global Settings';
                        if (str_contains($name, 'sub_admin')) return 'Admin Management';
                        if (str_contains($name, 'dashboard')) return 'Dashboard';
                        
                        return 'Other';
                    });
                @endphp

                <div class="space-y-5">
                    @foreach($groupedPermissions as $groupName => $permissions)
                        <div class="bg-gray-50 dark:bg-gray-700/30 rounded-xl border border-gray-200 dark:border-gray-600 overflow-hidden">
                            <div class="bg-gray-100 dark:bg-gray-800 px-4 py-2 border-b border-gray-200 dark:border-gray-600 flex justify-between items-center">
                                <h4 class="text-xs font-bold uppercase text-gray-500 dark:text-gray-400 tracking-wider">
                                    {{ $groupName }}
                                </h4>
                                </div>
                            
                            <div class="p-4 grid grid-cols-1 sm:grid-cols-2 gap-3">
                                @foreach($permissions as $perm)
                                    <label class="flex items-center space-x-3 cursor-pointer hover:bg-white dark:hover:bg-gray-700 p-2 rounded-lg transition-colors border border-transparent hover:border-gray-200 dark:hover:border-gray-500">
                                        <input type="checkbox" 
                                               value="{{ $perm->name }}" 
                                               wire:model="selectedPermissions" 
                                               class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 h-4 w-4">
                                        
                                        <div class="flex flex-col">
                                            <span class="text-sm font-medium text-gray-700 dark:text-gray-200 capitalize leading-none">
                                                {{-- Clean up name: "create projects" becomes just "Create" --}}
                                                {{ explode(' ', $perm->name)[0] }}
                                            </span>
                                            <span class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">
                                                {{ $perm->name }}
                                            </span>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="hidden"></button>
        </form>

        <x-slot name="footer">
            <button wire:click="save" class="px-4 py-2 bg-indigo-600 text-white rounded-lg">Save</button>
            <button wire:click="closeModal" class="px-4 py-2 border rounded-lg ml-2 text-gray-700">Cancel</button>
        </x-slot>
    </x-modal>
</div>