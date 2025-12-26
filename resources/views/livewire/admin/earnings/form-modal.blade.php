<x-modal :isOpen="$isModalOpen" title="Record New Earning">
    <form wire:submit.prevent="save">
        <div class="space-y-6">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <x-select label="Project" wire:model.live="project_id" name="project_id">
                    <option value="">Select Project...</option>
                    @foreach($projects as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </x-select>

                <x-input type="date" label="Date Received" wire:model="earning_date" name="earning_date" />
            </div>

            <x-input type="number" step="0.01" label="Total Amount Received ($)" wire:model.live.debounce.300ms="total_amount" name="total_amount" placeholder="0.00" class="text-lg font-bold" />

            @if(!empty($preview_breakdown) && $total_amount > 0)
            <div class="mt-4 bg-gray-50 dark:bg-gray-700/30 rounded-xl p-5 border border-gray-200 dark:border-gray-600 shadow-inner">
                <h4 class="text-xs font-bold text-gray-500 uppercase mb-4 tracking-wider border-b border-gray-200 dark:border-gray-600 pb-2">Distribution Preview</h4>
                
                <div class="space-y-2">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600 dark:text-gray-400">Gross Total</span>
                        <span class="font-bold text-gray-900 dark:text-white">${{ number_format($preview_breakdown['gross'], 2) }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-orange-600">
                        <span>Backup Reserve ({{ $preview_breakdown['backup_percent'] }}%)</span>
                        <span>- ${{ number_format($preview_breakdown['backup_amount'], 2) }}</span>
                    </div>
                    <div class="border-t border-dashed border-gray-300 dark:border-gray-600 my-2"></div>
                    <div class="flex justify-between text-sm font-bold text-green-600 mb-4">
                        <span>Net Distributable</span>
                        <span>${{ number_format($preview_breakdown['distributable'], 2) }}</span>
                    </div>
                </div>

                <div class="space-y-1.5 pt-2">
                    @foreach($preview_breakdown['payouts'] as $p)
                    <div class="flex justify-between items-center text-xs bg-white dark:bg-gray-800 p-2 rounded border border-gray-100 dark:border-gray-700">
                        <div class="flex items-center gap-2">
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ $p['name'] }}</span>
                            <span class="bg-gray-100 dark:bg-gray-700 text-gray-500 px-1.5 rounded text-[10px]">{{ $p['share_percent'] }}%</span>
                        </div>
                        <span class="font-bold text-gray-900 dark:text-white">${{ number_format($p['amount'], 2) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
        
        <button type="submit" class="hidden"></button>
    </form>

    <x-slot name="footer">
        @can('manage payouts')
            <button type="button" wire:click="save" class="px-6 py-2.5 rounded-xl bg-indigo-600 text-white hover:bg-indigo-700 font-semibold text-sm shadow-md shadow-indigo-200 transition-all transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Save Record
            </button>
        @endcan
        <button type="button" wire:click="closeModal" class="px-6 py-2.5 rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-50 font-medium text-sm transition-colors focus:outline-none">
            Cancel
        </button>
    </x-slot>
</x-modal>