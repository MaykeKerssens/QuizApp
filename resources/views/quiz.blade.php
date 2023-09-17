<x-app-layout>

    <div class="pt-6 mx-6 min-h-screen flex flex-col">
        <div class="text-gray-100 text-3xl mb-6 border-b border-gray-100 flex justify-between">
            <h2 class="">{{ $topic->name }}:</h2>
            <h2 class="text-lg">{{ $counter + 1 }}/10</h2>
        </div>


        <h2>{{ $counter + 1 }}. {{ $question->text }}</h2>

        <div class="space-y-4">
            @foreach ($answers as $answer)
                <x-secondary-button>
                    <a href="">{{ $answer->text }}</a>
                </x-secondary-button>
            @endforeach
        </div>

        <form action="{{ route('saveAnswer')}}">
            @csrf
            <input type="hidden" name="topic_id" value="{{ $topic->id }}">
            <input type="hidden" name="counter" value="{{ $counter }}">

            <x-primary-button>Submit</x-primary-button>
        </form>



    </div>

</x-app-layout>
