<x-app-layout>

    <div class="pt-6 mx-6 flex h-full flex-col">
        {{-- <form action="{{ route('saveAnswer') }}" class="flex flex-col justify-between h-full">
            @csrf
            <div> <!-- everything -->
                <div class="text-gray-100 text-3xl mb-4 border-b border-gray-100 flex justify-between">
                    <h2 class="">{{ $topic->name }}:</h2>
                </div>

                <div class="bg-gray-100">
                    <h4>Goed gedaan!!</h4>
                    <p>80% juist</p>
                    <p>16/20 vragen goed</p>
                </div>

            </div>

            <div> <!-- submit button -->
                <x-primary-button>Terug naar overzicht</x-primary-button>
            </div>
        </form> --}}
        <div class="bg-gray-100 p-4">

            @for ($x = 0; $x < $questionsAmount; $x++)
            <div class="p-2">
                <p>{{ $x + 1}}. {{ $questions[$x]->text }}</p>

                <!-- Show if user answer is corrct-->
                @if ($userAnswers[$x]->isCorrect == true)
                    <p class="text-green-500">{{ $userAnswers[$x]->answer->text }}</p>
                @else
                    <p class="text-red-500">{{ $userAnswers[$x]->answer->text }}</p>
                    @foreach ( $questions[$x]->answers as $answer )
                        @if ($answer->isCorrect)
                            <p class="text-green-500">{{ $answer->text }}</p>
                        @endif
                    @endforeach
                @endif
            </div>
            @endfor
        </div>
    </div>



</x-app-layout>
