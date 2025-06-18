@extends('layouts.app')

@section('content')
    <section class="p-4 max-w-md mx-auto space-y-4">
        <h1 class="text-2xl font-bold">اختيار اللغة</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('settings.language.set') }}" class="space-y-4">
            @csrf
            @foreach($options as $code => $label)
                <label class="flex items-center space-x-2">
                    <input
                        type="radio"
                        name="language"
                        value="{{ $code }}"
                        {{ $current === $code ? 'checked' : '' }}
                        class="form-radio"
                    >
                    <span>{{ $label }}</span>
                </label>
            @endforeach

            @error('language')
            <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror

            <button type="submit"
                    class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                حفظ اللغة
            </button>
        </form>
    </section>
@endsection
