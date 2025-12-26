<div class="w-full max-w-md mx-auto">
    <div class="mb-8 sm:mb-10 text-center sm:text-left">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
            Sign in to Fino
        </h3>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            Welcome back! Please enter your details.
        </p>
    </div>

    <form wire:submit.prevent="login" class="space-y-5 sm:space-y-6">
        
        <div class="space-y-2">
            <label for="email" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                Email
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <input wire:model="email" id="email" type="email" autocomplete="email" required placeholder="Enter your email" 
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

        <div class="space-y-2">
            <label for="password" class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                Password
            </label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400 group-focus-within:text-indigo-600 transition-colors duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                </div>
                <input wire:model="password" id="password" type="password" autocomplete="current-password" required placeholder="••••••••" 
                    class="block w-full pl-11 pr-4 py-2.5 sm:py-3 bg-gray-50 dark:bg-gray-700/50 border border-gray-200 dark:border-gray-600 rounded-xl text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:bg-white dark:focus:bg-gray-700 focus:ring-2 focus:ring-indigo-600/20 focus:border-indigo-600 transition-all duration-200 text-sm sm:text-base"
                >
            </div>
            @error('password') 
                <p class="text-xs text-red-500 mt-1 font-medium flex items-center">
                    <svg class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    {{ $message }}
                </p> 
            @enderror
        </div>

        <div class="flex flex-col gap-y-3 sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center">
                <input wire:model="remember" id="remember_me" name="remember_me" type="checkbox" 
                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded cursor-pointer transition ease-in-out duration-150"
                >
                <label for="remember_me" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 cursor-pointer select-none">
                    Remember me
                </label>
            </div>

            <div class="text-sm">
                <a href="{{ route('password.request') }}" wire:navigate class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 transition-colors">
                    Forgot password?
                </a>
            </div>
        </div>

        <button type="submit" 
            class="w-full flex justify-center py-2.5 sm:py-3 px-4 border border-transparent rounded-xl shadow-lg shadow-indigo-600/20 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 transform hover:-translate-y-0.5 active:translate-y-0"
        >
            <span wire:loading.remove wire:target="login">Sign in</span>
            
            <div wire:loading wire:target="login" class="flex items-center">
                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Processing...
            </div>
        </button>
    </form>
</div>