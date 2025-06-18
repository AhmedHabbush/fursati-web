@extends('layouts.app')

@section('content')
    <section class="p-4 max-w-md mx-auto space-y-4">
        <h1 class="text-2xl font-bold">Login</h1>
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <label class="block">
                <span>API Token</span>
                <input name="api_token" type="text"
                       class="w-full border rounded px-3 py-2" required>
            </label>
            @error('api_token')
            <div class="text-red-600 text-sm">{{ $message }}</div>
            @enderror
            <button type="submit"
                    class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                Login
            </button>
            <p class="mt-2 text-sm">
                ليس لديك حساب؟ <a href="{{ route('register') }}" class="text-blue-600">سجّل الآن</a>
            </p>
        </form>
    </section>
@endsection
