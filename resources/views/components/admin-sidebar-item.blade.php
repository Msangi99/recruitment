@props(['href', 'icon', 'label', 'active' => false, 'badge' => null, 'variant' => 'admin'])

@php
    $isCandidate = $variant === 'candidate';

    $baseClasses = 'flex items-center px-4 py-3.5 rounded-lg transition-all duration-200 group ';

    if ($isCandidate) {
        $activeClasses = 'bg-white/20 text-white ring-1 ring-white/10 shadow-lg';
        $inactiveClasses = 'text-white/60 hover:text-white hover:bg-white/5';
        $iconActiveClasses = 'text-white';
        $iconInactiveClasses = 'text-emerald-300';
    } else {
        $activeClasses = 'pluto-sidebar-active shadow-lg';
        $inactiveClasses = 'text-gray-400 hover:text-white pluto-sidebar-item';
        $iconActiveClasses = 'text-white';
        $iconInactiveClasses = 'text-orange-500';
    }
@endphp

<a href="{{ $href }}" {{ $attributes->merge(['class' => $baseClasses . ($active ? $activeClasses : $inactiveClasses)]) }}>
    <div class="mr-4 flex items-center justify-center transition-transform duration-200 group-hover:scale-110">
        <i data-lucide="{{ $icon }}" class="w-5 h-5 {{ $active ? $iconActiveClasses : $iconInactiveClasses }}"></i>
    </div>
    <span class="text-[14px] font-bold tracking-wide">{{ $label }}</span>
    @if($badge)
        <span
            class="ml-auto inline-flex items-center justify-center px-2 py-0.5 text-xs font-bold leading-none text-white bg-red-500 rounded-full">
            {{ $badge }}
        </span>
    @elseif($active)
        <div class="ml-auto">
            <i data-lucide="chevron-right" class="w-4 h-4 text-white/50"></i>
        </div>
    @endif
</a>