@php
    $colors = [
        'success' => 'bg-green-50 border-green-400 text-green-700',
        'error' => 'bg-red-50 border-red-400 text-red-700',
    ];
@endphp

@if(session($type))
    <div class="mb-4 p-4 border-l-4 {{ $colors[$type] ?? $colors['success'] }}">
        {{ session($type) }}
    </div>
@endif
