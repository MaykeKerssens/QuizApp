<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <form action="{{ route('question.store') }}" method="POST" enctype="multipart/form-data" class="bg-gray-100 ">
        {{-- //TODO: Add selection for topic --}}
        @csrf
        <input type="file" name="question_file">
        <button type="submit">Upload File</button>
    </form>


</x-app-layout>
