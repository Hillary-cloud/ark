@props(['value'])

<label {{ $attributes->merge(['class' => 'font-weight-medium text-sm text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>
