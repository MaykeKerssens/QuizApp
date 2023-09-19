<button {{ $attributes->merge(['type' => 'submit', 'class' => 'bg-yellow-500 py-3 px-3 rounded-lg items-center text-2xl font-semibold min-w-full mb-4']) }}>
    {{ $slot }}
</button>
