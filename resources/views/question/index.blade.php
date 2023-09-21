<x-app-layout>
    <div class="pt-6 mx-6 flex h-full flex-col">
        <div class="flex flex-col justify-between h-full">

            <div> <!-- Everything -->
                <div>
                    <div class="text-gray-100 text-3xl mb-4 border-b border-gray-100">
                        <h2>All questions:</h2>
                    </div>
                </div>

                <div class="max-h-96 overflow-y-auto rounded-lg">
                    <table class="bg-gray-100 mt-2 rounded-lg table table-auto border-collapse">
                        <thead>
                            <tr class="rounded-t-lg bg-yellow-400 min-w-full">
                                <td class="rounded-tl-lg">Question</td>
                                <td>Topic</td>
                                <td>Pointworth</td>
                                <td>Type</td>
                                <td>Correct answer</td>
                                <td>Answer A</td>
                                <td>Answer B</td>
                                <td>Answer C</td>
                                <td class="rounded-tr-lg">Delete</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                                <tr class="px-6 border-2 border-gray-300">
                                    <td>{{ $question->text }}</td>
                                    <td>{{ $question->topic->name }}</td>
                                    <td>{{ $question->point_worth }}</td>
                                    <td>{{ $question->type }}</td>
                                    <td>{{ $question->correct_answer ? $question->correct_answer : '-' }}</td>
                                    @foreach ($answers as $answer)
                                        @if ($answer->question_id == $question->id)
                                            <td>{{ $answer->text }} {{ $answer->isCorrect ? '(correct)' : '' }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div> <!-- submit button -->
                <x-primary-button><a href="{{ route('dashboard') }}">Back to menu</a></x-primary-button>
            </div>
        </div>
</x-app-layout>
