<button {{ $attributes->merge(['class' => 'px-4 py-2 bg-indigo-500 text-white font-bold rounded-lg shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500']) }}>
    {{ $slot }}
</button>
