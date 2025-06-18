@extends('layouts.app')

@section('content')
    <section class="p-4 max-w-lg mx-auto space-y-6">
        <h1 class="text-2xl font-bold">Help & Feedback</h1>

        {{-- عرض الرسائل --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-800 p-4 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('settings.help.submit') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name') }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Subject</label>
                <input type="text" name="subject" value="{{ old('subject') }}"
                       class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Message</label>
                <textarea name="message" rows="5"
                          class="w-full border rounded px-3 py-2" required>{{ old('message') }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">Attachments (up to 5 files)</label>
                <input type="file" name="attachments[]" multiple class="w-full">
                <p class="text-sm text-gray-500">Max size per file: 5MB</p>
            </div>

            <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                Submit Feedback
            </button>
        </form>
    </section>
@endsection
