<button {{ $attributes->merge(['type' => 'button', 'class' => 'bg-yellow-400 p-2 px-3 rounded-full items-center font-semibold min-w-full']) }}>
    {{ $slot }}
</button>
