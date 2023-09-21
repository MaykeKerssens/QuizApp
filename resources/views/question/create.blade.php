<x-app-layout>
    <div class="pt-6 mx-6 flex h-full flex-col">
    <form action="{{ route('question.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col justify-between h-full">
        @csrf

        <div> <!-- Everything -->
            <div>
                <div class="text-gray-100 text-3xl mb-4 border-b border-gray-100 flex justify-between">
                    <h2 class="">Create questions:</h2>
                </div>
            </div>

            <div class="bg-gray-100 rounded-lg p-4 gap-y-2 max-h-96 overflow-y-auto">
                <p class="text-purple-900 font-bold text-lg">Choose a topic:</p>
                <select name="selected_topic" id="topic">
                    <option>Topics</option>
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->name }}">{{ $topic->name }}</option>
                    @endforeach
                </select>

                <p class="text-purple-900 font-bold text-lg">Select a file with questions:</p>
                <input type="file" name="question_file">


                <!-- Manually add questions -->
                <p class="text-purple-900 font-bold text-lg">Enter question:</p>
                <input type="text" name="question_text">

                <p class="text-purple-900 font-bold text-lg">Set pointworth:</p>
                <input type="number" name="question_point_worth">

                <p class="text-purple-900 font-bold text-lg">Choose question type:</p>
                <select name="question_type" id="question_type" onchange="toggleFields()">
                    <option value="">Question types</option>
                    <option value="multipleChoice">Multiple choice</option>
                    <option value="openAnswer">Open answer</option>
                </select>

                {{-- //TODO: Add hint field? --}}


                <!-- Script for toggling MultipleChoice and OpenAnswer fields -->
                <script>
                    function toggleFields() {
                        var selectedOption = document.getElementById('question_type').value;
                        var multipleChoiceFields = document.getElementById('multipleChoiceFields');
                        var openAnswerFields = document.getElementById('openAnswerFields');

                        if (selectedOption === 'multipleChoice') {
                            multipleChoiceFields.style.display = 'block';
                            openAnswerFields.style.display = 'none';
                        } else if (selectedOption === 'openAnswer') {
                            multipleChoiceFields.style.display = 'none';
                            openAnswerFields.style.display = 'block';
                        } else {
                            // Handle other cases if needed
                            multipleChoiceFields.style.display = 'none';
                            openAnswerFields.style.display = 'none';
                        }
                    }
                </script>

                <!-- Multiple choice questions -->
                <div id="multipleChoiceFields" style="display: none">
                    <p class="text-purple-900 font-bold text-lg">Enter answer A:</p>
                    <input type="text" name="answer_a_text">
                    <input type="checkbox" name="answer_a_isCorrect">

                    <p class="text-purple-900 font-bold text-lg">Enter answer B:</p>
                    <input type="text" name="answer_b_text">
                    <input type="checkbox" name="answer_b_isCorrect">

                    <p class="text-purple-900 font-bold text-lg">Enter answer C:</p>
                    <input type="text" name="answer_c_text">
                    <input type="checkbox" name="answer_c_isCorrect">
                </div>

                <!-- Open Answer question -->
                <div id="openAnswerFields" style="display: none">
                    <p class="text-purple-900 font-bold text-lg">Enter correct answer:</p>
                    <input type="text" name="question_correct_answer">
                </div>

            </div>
        </div>

        <div class="bg-gray-100 rounded-lg gap-y-2 px-6 py-2">
            <p class="text-purple-900 font-bold  text-lg">Feedback:</p>
            <p>{{ $errors }}</p>
            @if(session('success'))
                <div class="">
                    {{ session('success') }}
                </div>
            @endif
            {{-- //TODO: Add feedback after adding questions --}}
        </div>

        <div> <!-- submit button -->
            <x-primary-button><a href="{{ route('dashboard') }}">Add questions</a></x-primary-button>
        </div>
    </form>
    </div>
</x-app-layout>
