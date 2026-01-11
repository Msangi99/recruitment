@props(['label', 'name', 'type' => 'text', 'value' => '', 'required' => false, 'placeholder' => '', 'help' => '', 'options' => []])

<div>
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2">
            {{ $label }}
            @if($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif
    
    @if($type === 'textarea')
        <textarea id="{{ $name }}" name="{{ $name }}" rows="{{ $attributes->get('rows', 4) }}"
                  class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error($name) border-red-300 @enderror"
                  placeholder="{{ $placeholder }}"
                  {{ $required ? 'required' : '' }}>{{ old($name, $value) }}</textarea>
    @elseif($type === 'select')
        <select id="{{ $name }}" name="{{ $name }}"
                class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error($name) border-red-300 @enderror"
                {{ $required ? 'required' : '' }}>
            @if($attributes->get('placeholder'))
                <option value="">{{ $attributes->get('placeholder') }}</option>
            @endif
            @foreach($options as $optionValue => $optionLabel)
                <option value="{{ $optionValue }}" {{ old($name, $value) == $optionValue ? 'selected' : '' }}>
                    {{ $optionLabel }}
                </option>
            @endforeach
        </select>
    @elseif($type === 'checkbox')
        <div class="flex items-center">
            <input id="{{ $name }}" name="{{ $name }}" type="checkbox" value="{{ $attributes->get('checkbox-value', '1') }}"
                   class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                   {{ old($name, $value) ? 'checked' : '' }}>
            <label for="{{ $name }}" class="ml-3 block text-sm text-gray-700">
                {{ $attributes->get('checkbox-label', '') }}
            </label>
        </div>
    @else
        <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}" value="{{ old($name, $value) }}"
               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm @error($name) border-red-300 @enderror"
               placeholder="{{ $placeholder }}"
               {{ $required ? 'required' : '' }}
               {{ $attributes }}>
    @endif
    
    @error($name)
        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
    @enderror
    
    @if($help)
        <p class="mt-2 text-xs text-gray-500">{{ $help }}</p>
    @endif
</div>