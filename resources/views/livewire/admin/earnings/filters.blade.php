<div class="bg-white dark:bg-gray-800 p-1.5 rounded-2xl shadow-sm border border-gray-200 dark:border-gray-700 mb-8 flex flex-col md:flex-row items-center gap-2">
    
    <div class="relative w-full md:flex-1 group">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
            </svg>
        </div>
        <select wire:model.live="selectedProject" class="block w-full pl-11 pr-10 py-2.5 sm:text-sm border-none rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-colors cursor-pointer hover:bg-gray-100 dark:hover:bg-black/20 font-medium">
            <option value="">All Projects</option>
            @foreach($projects as $p)
            <option value="{{ $p->id }}">{{ $p->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="hidden md:block w-px h-8 bg-gray-200 dark:bg-gray-700"></div>

    <div 
        class="relative w-full md:w-auto min-w-[260px] group"
        x-data="{
            picker: null,
            initFlatpickr() {
                this.picker = flatpickr(this.$refs.rangeInput, {
                    mode: 'range',
                    dateFormat: 'Y-m-d',
                    defaultDate: [@js($dateFrom), @js($dateTo)],
                    onChange: (selectedDates, dateStr) => {
                        // Flatpickr returns 'YYYY-MM-DD to YYYY-MM-DD'
                        if (selectedDates.length === 2) {
                            let dates = dateStr.split(' to ');
                            @this.set('dateFrom', dates[0]);
                            @this.set('dateTo', dates[1]);
                        } else if (selectedDates.length === 0) {
                            @this.set('dateFrom', null);
                            @this.set('dateTo', null);
                        }
                    }
                });
            },
            clearDate() {
                this.picker.clear();
                @this.set('dateFrom', null);
                @this.set('dateTo', null);
            }
        }"
        x-init="initFlatpickr"
    >
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
            <svg class="h-5 w-5 text-gray-400 group-hover:text-indigo-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </div>

        <input 
            x-ref="rangeInput" 
            type="text" 
            class="block w-full pl-11 pr-10 py-2.5 sm:text-sm border-none rounded-xl bg-gray-50 dark:bg-gray-900 text-gray-900 dark:text-white focus:ring-2 focus:ring-indigo-500 transition-colors cursor-pointer hover:bg-gray-100 dark:hover:bg-black/20 font-medium placeholder-gray-500" 
            placeholder="Select Date Range..."
            readonly
        >

        @if($dateFrom || $dateTo)
            <button 
                @click="clearDate()" 
                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-red-500 transition-colors"
                type="button"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        @endif
    </div>

</div>