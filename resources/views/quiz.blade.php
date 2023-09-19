<x-app-layout>

    <div class="pt-6 mx-6 flex h-full flex-col">
        <form action="{{ route('saveAnswer') }}" class="flex flex-col justify-between h-full">
            @csrf
            <div> <!-- everything -->
                <div class="text-gray-100 text-3xl mb-4 border-b border-gray-100 flex justify-between">
                    <h2 class="">{{ $question->topic->name }}:</h2>
                    <h2 class="text-lg">{{ $counter + 1 }}/{{ $questionsAmount }}</h2>
                </div>

                <h2 class="text-gray-100 text-lg">{{ $counter + 1 }}. {{ $question->text }}</h2>

                <div class="min-h-full flex flex-col justify-between mt-6">
                    <div class="space-y-4">
                        @foreach ($answers as $answer)
                            <x-secondary-button class="answer-button" data-answer-id="{{ $answer->id }}">
                                {{ $answer->text }}

                            </x-secondary-button>
                        @endforeach

                        <script>
                            const buttons = document.querySelectorAll('button');

                            buttons.forEach(button => {
                                button.addEventListener('click', () => {
                                    // Remove the selected classes from all buttons
                                    buttons.forEach(btn => {
                                        btn.classList.remove('bg-yellow-200');
                                        btn.classList.add('bg-yellow-400');
                                    });

                                    // Add selected classes to the clicked button
                                    button.classList.remove('bg-yellow-400');
                                    button.classList.add('bg-yellow-200');

                                    // Set the value of the hidden input to the selected answer's ID
                                    const selectedAnswerId = button.getAttribute('data-answer-id');
                                    document.querySelector('#selected_answer_id').value = selectedAnswerId;
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>

            <!-- hidden inputs -->
            @if ($question->type == 'multipleChoice')
                <input type="hidden" name="selected_answer_id" id="selected_answer_id" value="">
            @else
                <input type="hidden" name="response" value="">
            @endif

            <input type="hidden" name="question_id" value="{{ $question->id }}">
            <input type="hidden" name="questionsAmount" value="{{ $questionsAmount }}">
            <input type="hidden" name="counter" value="{{ $counter }}">

            <div> <!-- submit button -->
                <x-primary-button>Submit</x-primary-button>
            </div>

        </form>
    </div>

</x-app-layout>
