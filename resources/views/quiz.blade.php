<x-app-layout>
    <div class="pt-6 mx-6 min-h-screen flex flex-col">
        <div class="text-gray-100 text-3xl mb-6 border-b border-gray-100 flex justify-between">
            <h2 class="">{{ $topic->name }}:</h2>
            <h2 class="text-lg">3/10</h2>
        </div>

        <div class="space-y-4">
            <x-secondary-button>
                <a href="">Answer A</a>
            </x-secondary-button>
            <x-secondary-button>
                <a href="">Answer B</a>
            </x-secondary-button>
            <x-secondary-button>
                <a href="">Answer C</a>
            </x-secondary-button>
        </div>

    </div>

</x-app-layout>
