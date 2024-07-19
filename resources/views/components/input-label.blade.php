@props(['for', 'value'])

<label for="{{ $for }}" {{ $attributes->merge(['class' => 'block text-gray-600 font-semibold']) }}>
    {{ $value ?? $slot }}
</label>
