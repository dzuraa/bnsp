@props(['field', 'label', 'sortable' => true])

@php
    $isSorted = request('sort') === $field;
    $direction = request('direction') === 'asc' ? 'desc' : 'asc';
@endphp

<th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider whitespace-nowrap">
    @if($sortable)
        <a href="{{ request()->fullUrlWithQuery(['sort' => $field, 'direction' => $isSorted && request('direction') === 'asc' ? 'desc' : 'asc']) }}"
           class="flex items-center gap-1 hover:underline">
            {{ $label }}
            @if($isSorted)
                <span class="text-xs">
                    {{ request('direction') === 'asc' ? '▲' : '▼' }}
                </span>
            @endif
        </a>
    @else
        {{ $label }}
    @endif
</th>
