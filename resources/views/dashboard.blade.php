<x-app-layout>

    <div class="pt-6 mx-6 min-h-screen flex flex-col">
        <h2 class="text-gray-100 text-3xl pb-6 underline decoration-2 underline-offset-8">Topics:</h2>

        <div class="space-y-4">
            @foreach ($topics as $topic)
            {{-- //TODO: figure out how to send quesiton id with route --}}
                <x-secondary-button>
                    <a href="{{ route('quiz',$topic->id) }}">{{ $topic->name }}</a>
                </x-secondary-button>
            @endforeach
        </div>
    </div>


    {{-- <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>
