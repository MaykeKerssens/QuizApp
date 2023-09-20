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

            <div class="bg-gray-100 rounded-lg p-4 gap-y-2">
                <p class="text-purple-900 font-bold text-lg">Choose a topic:</p>
                <select name="topic" id="topic">
                    @foreach ($topics as $topic)
                        <option value="{{ $topic->name }}">{{ $topic->name }}</option>
                    @endforeach
                </select>

                <p class="text-purple-900 font-bold text-lg">Select a file with questions:</p>
                <input type="file" name="question_file">
            </div>

            <div class="bg-gray-100 rounded-lg p-4 gap-y-2 mt-4">
                <p class="text-purple-900 font-bold text-lg">Enter question:</p>
                <input type="text" name="question_text">

                <p class="text-purple-900 font-bold text-lg">Set pointworth:</p>
                <input type="number" name="question_point_worth">


                <h2>/////// Multiple choice questions</h2>
                <p class="text-purple-900 font-bold text-lg">Enter answer A:</p>
                <input type="text" name="question_text">
                <input type="checkbox">

                <p class="text-purple-900 font-bold text-lg">Enter answer B:</p>
                <input type="text" name="question_text">
                <input type="checkbox">

                <p class="text-purple-900 font-bold text-lg">Enter answer C:</p>
                <input type="text" name="question_text">
                <input type="checkbox">


                <h2>//////// Open Answer question</h2>
                <p class="text-purple-900 font-bold text-lg">Enter correct answer:</p>
                <input type="text" name="question_text">

                {{-- //TODO: Add hints? --}}
            </div>
        </div>



        <div> <!-- submit button -->
            <x-primary-button><a href="{{ route('dashboard') }}">Terug naar overzicht</a></x-primary-button>
        </div>
    </form>
    </div>

    {{-- //TODO: Add feedback after adding questions --}}
</x-app-layout>
