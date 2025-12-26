<div class="w-full max-w-md mx-auto">
    
    <div class="mb-8 sm:mb-10 text-center sm:text-left">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
            Forgot Password?
        </h3>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            No worries. Enter your email and we'll send you reset instructions.
        </p>
    </div>

    @if (session('status'))
        <div class="mb-6 rounded-xl bg-green-50 dark:bg-green-900/30 p-4 border border-green-200 dark:border-green-800">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm font-medium text-green-800 dark:text-green-200">
                        {{ session('status') }}
                    </p>
                </div>
            </div>
        </div>
    @endif

    <form wire:submit.prevent="sendResetLink" class="space-y-5 sm:space-y-6">
        
        <div class="space-y-2">
            <label for="email" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                Email Address
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <input wire:model="email" id="email" type="email" autocomplete="email" required placeholder="Enter your email" autofocus
                    class="block w-full pl-11 pr-4 py-2.5 sm:py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all duration-200 text-sm sm:text-base"
                >
            </div>
            @error('email') 
                <p class="text-xs text-red-500 mt-1 font-medium flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <button type="submit" 
            class="w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-600/20 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0"
        >
            <span wire:loading.remove wire:target="sendResetLink">
                Send Reset Link
            </span>
            
            <span wire:loading.flex wire:target="sendResetLink" class="items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Sending...
            </span>
        </button>

        <div class="text-center mt-6">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Remember your password? 
                <a href="{{ route('login') }}" wire:navigate class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 transition-colors inline-flex items-center">
                    Back to Sign in
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                </a>
            </p>
        </div>
    </form>
</div>