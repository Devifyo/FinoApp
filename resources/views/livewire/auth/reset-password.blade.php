<div class="w-full max-w-md mx-auto">
    
    <div class="mb-8 sm:mb-10 text-center sm:text-left">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
            Reset Password
        </h3>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Create a new, strong password for your account.
        </p>
    </div>

    <form wire:submit.prevent="resetPassword" class="space-y-5 sm:space-y-6">
        
        <input type="hidden" wire:model="token">

        <div class="space-y-2">
            <label for="email" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Email Address</label>
            <div class="relative group">
                <input wire:model="email" id="email" type="email" required readonly
                    class="block w-full px-4 py-2.5 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-500 cursor-not-allowed sm:text-base"
                >
            </div>
            @error('email') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-2">
            <label for="password" class="text-sm font-semibold text-gray-700 dark:text-gray-300">New Password</label>
            <input wire:model="password" id="password" type="password" required placeholder="••••••••" autofocus
                class="block w-full px-4 py-2.5 sm:py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all sm:text-base"
            >
            @error('password') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
        </div>

        <div class="space-y-2">
            <label for="password_confirmation" class="text-sm font-semibold text-gray-700 dark:text-gray-300">Confirm Password</label>
            <input wire:model="password_confirmation" id="password_confirmation" type="password" required placeholder="••••••••"
                class="block w-full px-4 py-2.5 sm:py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all sm:text-base"
            >
        </div>

        <button type="submit" 
            class="w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-600/20 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all transform hover:-translate-y-0.5"
        >
            <span wire:loading.remove wire:target="resetPassword">Reset Password</span>
            <span wire:loading wire:target="resetPassword">Processing...</span>
        </button>

    </form>
</div>