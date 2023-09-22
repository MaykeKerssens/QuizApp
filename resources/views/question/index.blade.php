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
                    <table class="bg-gray-100 rounded-lg table table-auto ">
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
                                    <td class="border-2 border-gray-300">{{ $question->text }}</td>
                                    <td class="border-2 border-gray-300">{{ $question->topic->name }}</td>
                                    <td class="border-2 border-gray-300">{{ $question->point_worth }}</td>
                                    <td class="border-2 border-gray-300">{{ $question->type }}</td>
                                    <td class="border-2 border-gray-300">
                                        {{ $question->correct_answer ? $question->correct_answer : '-' }}</td>
                                    @if ($question->type == 'multipleChoice')
                                        @foreach ($answers as $answer)
                                            @if ($answer->question_id == $question->id)
                                                <td class="border-2 border-gray-300">{{ $answer->text }}
                                                    {{ $answer->isCorrect ? '(correct)' : '' }}</td>
                                            @endif
                                        @endforeach
                                    @else
                                        <td class="border-2 border-gray-300">-</td>
                                        <td class="border-2 border-gray-300">-</td>
                                        <td class="border-2 border-gray-300">-</td>
                                    @endif
                                    <td>
                                        <form method="POST" action="{{ route('questions.destroy', $question->id) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 border-2 border-red-500 p-1">Delete question</button>
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-100 rounded-lg gap-y-2 px-6 py-2 mt-2">
                    <p class="text-purple-900 font-bold text-lg">Feedback:</p>
                    <p>{{ $errors }}</p>
                    @if(session('success'))
                        <div class="">
                            {{ session('success') }}
                        </div>
                    @endif
                </div>



            </div>

            <div> <!-- submit button -->
                <x-primary-button><a href="{{ route('dashboard') }}">Back to menu</a></x-primary-button>
            </div>
        </div>
</x-app-layout>
