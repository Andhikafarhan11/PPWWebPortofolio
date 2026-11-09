@props(['label', 'value', 'color' => 'text-blue-600'])

<div class="bg-white rounded-lg shadow-md p-6 card border-0 shadow-sm p-3">
    <div class="text-sm text-gray-500 text-muted uppercase text-uppercase tracking-wider small fw-semibold">
        {{ $label }}
    </div>
    <div class="text-3xl fs-2 font-bold fw-bold {{ $color }} mt-2">
        {{ $value }}
    </div>
</div>