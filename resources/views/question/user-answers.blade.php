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
                    <table class="bg-gray-100 rounded-lg table-fixed min-w-full">
                        <thead>
                            <tr class="rounded-t-lg bg-yellow-400">
                                <td class="rounded-tl-lg border-x-2 border-yellow-500">Question / student </td>
                                <td class="rounded-tr-lg border-x-2 border-yellow-500">Answer</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($questions as $question)
                                <tr class="px-6 border-2 border-gray-300 bg-gray-300">
                                    <td class="border-2 border-gray-200 text-bold">{{ $question->text }}</td>

                                    @if ($question->type == 'multipleChoice')
                                        @foreach ($question->answers as $answer)
                                            @if ($answer->isCorrect)
                                                <td class="border-2 border-gray-200">{{ $answer->text }}</td>
                                            @endif
                                        @endforeach
                                    @else
                                        <td class="border-2 border-gray-200">{{ $question->correct_answer }}</td>
                                    @endif
                                </tr>

                                <!-- User answers-->
                                @foreach ($question->userResponses as $userResponse)
                                    <tr>
                                        <td class="border-2 border-gray-200">{{ $userResponse->user->name }}</td>

                                        @if ($userResponse->isCorrect == true)
                                            <td class="border-2 border-gray-200 text-green-500">{{ $userResponse->response ? $question->correct_answer : $userResponse->answer->text }}</td>
                                        @else
                                            <td class="border-2 border-gray-200 text-red-500">{{ $userResponse->response ? $question->correct_answer :  $userResponse->answer->text }}</td>
                                        @endif
                                        @if ($question->type == 'multipleChoice')

                                        @else
                                        @endif
                                    </tr>
                                @endforeach

                                <tr> <!-- Empty row between each question-->
                                    <td class="py-3"></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-gray-100 rounded-lg gap-y-2 px-6 py-2 mt-2">
                    <p class="text-purple-900 font-bold text-lg">Feedback:</p>
                    <p>{{ $errors }}</p>
                    @if (session('success'))
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
