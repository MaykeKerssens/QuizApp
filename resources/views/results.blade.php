<x-app-layout>

    <div class="pt-6 mx-6 flex h-full flex-col">
        <form action="{{ route('saveAnswer') }}" class="flex flex-col justify-between h-full">
            @csrf
            <div> <!-- everything -->
                <div class="text-gray-100 text-3xl mb-4 border-b border-gray-100 flex justify-between">
                    <h2 class="">{{ $topic->name }}:</h2>
                </div>

                <!-- Results -->
                <div class="bg-gray-100 rounded-lg p-4 mb-3 max-h-96 overflow-y-auto">
                    @php
                        $correctAnswers = 0;
                        $totalPoints = 0;
                    @endphp
                    @for ($i = 0; $i < $questionsAmount; $i++)
                        <div class="p-2">
                            <p class="text-purple-900 font-bold  text-lg">{{ $i + 1 }}. {{ $questions[$i]->text }}
                            </p>

                            <!-- Show if user answer is corrct-->
                            @if ($userAnswers[$i]->isCorrect == true)
                                <p class="text-green-500">{{ $userAnswers[$i]->answer->text }}
                                    (+{{ $questions[$i]->point_worth }})</p>
                                @php
                                    $correctAnswers += 1;
                                    $totalPoints += $questions[$i]->point_worth;
                                @endphp
                            @else
                                <p class="text-red-500">{{ $userAnswers[$i]->answer->text }}</p>
                                @foreach ($questions[$i]->answers as $answer)
                                    @if ($answer->isCorrect)
                                        <p class="text-green-500">{{ $answer->text }}</p>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    @endfor
                </div>

                <div class="bg-gray-100 rounded-lg gap-y-2 px-6 py-2">
                    <p class="text-purple-900 font-bold  text-lg">Resultaten:</p>
                    <p>{{ $correctAnswers }}/{{ $questionsAmount }} vragen goed</p>
                    <p>{{ $totalPoints }} punten verdiend</p>
                </div>
            </div>

            <div> <!-- submit button -->
                <x-primary-button><a href="{{ route('dashboard') }}">Terug naar overzicht</a></x-primary-button>
            </div>
        </form>
    </div>



</x-app-layout>
