@if($isDeleteModalOpen)
<div class="fixed inset-0 z-[60] flex items-center justify-center p-4 sm:p-6" role="dialog" aria-modal="true">
    <div class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm transition-opacity"></div>
    <div class="relative bg-white dark:bg-gray-800 rounded-2xl shadow-xl w-full max-w-sm p-6 text-center transform transition-all scale-100">
        
        <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
            </svg>
        </div>
        
        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-2">Delete Project?</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">
            Are you sure you want to delete this project? This action cannot be undone and will remove all associated member data.
        </p>

        <div class="grid grid-cols-2 gap-3">
            <button wire:click="closeModal" class="w-full justify-center rounded-xl border border-gray-300 px-4 py-2 bg-white text-base font-medium text-gray-700 shadow-sm hover:bg-gray-50 focus:outline-none sm:text-sm transition-colors">
                Cancel
            </button>
            <button wire:click="delete" class="w-full justify-center rounded-xl border border-transparent px-4 py-2 bg-red-600 text-base font-medium text-white shadow-sm hover:bg-red-700 focus:outline-none sm:text-sm transition-colors">
                Delete It
            </button>
        </div>
    </div>
</div>
@endif