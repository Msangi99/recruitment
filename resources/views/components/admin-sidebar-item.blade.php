@props(['href', 'icon', 'label', 'active' => false])

<a href="{{ $href }}" 
   {{ $attributes->merge(['class' => 'flex items-center px-4 py-3.5 rounded-lg transition-all duration-200 group ' . ($active ? 'pluto-sidebar-active shadow-lg' : 'text-gray-400 hover:text-white pluto-sidebar-item')]) }}>
    <div class="mr-4 flex items-center justify-center transition-transform duration-200 group-hover:scale-110">
        <i data-lucide="{{ $icon }}" class="w-5 h-5 {{ $active ? 'text-white' : 'text-orange-500' }}"></i>
    </div>
    <span class="text-[14px] font-bold tracking-wide">{{ $label }}</span>
    @if($active)
        <div class="ml-auto">
            <i data-lucide="chevron-right" class="w-4 h-4 text-white/50"></i>
        </div>
    @endif
</a>
