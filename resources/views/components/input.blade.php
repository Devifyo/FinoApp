@props(['label' => null, 'name' => null, 'type' => 'text'])

<div class="w-full">
    @if($label)
        <label class="block text-xs font-semibold text-gray-500 uppercase tracking-wide mb-1.5">
            {{ $label }}
        </label>
    @endif

    <input 
        type="{{ $type }}"
        {{ $attributes->whereStartsWith('wire:model') }}
        {{ $attributes->merge(['class' => 'block w-full rounded-lg border-gray-300 bg-white text-gray-900 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm py-2.5 px-3 dark:bg-gray-800 dark:border-gray-600 dark:text-white dark:focus:ring-indigo-600']) }}
    >

    @if($name)
        @error($name) 
            <p class="mt-1 text-xs text-red-500 font-medium">{{ $message }}</p> 
        @enderror
    @endif
</div>