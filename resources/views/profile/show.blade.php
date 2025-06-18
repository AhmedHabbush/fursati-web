@extends('layouts.app')

@section('content')
    <section class="p-4 max-w-md mx-auto space-y-6">
        <h1 class="text-2xl font-bold">My Profile</h1>

        <div class="bg-white rounded-xl shadow p-4 space-y-2">
            <p><span class="font-medium">Name:</span> {{ $user['name'] ?? '—' }}</p>
            <p><span class="font-medium">Email:</span> {{ $user['email'] ?? '—' }}</p>
            <p><span class="font-medium">Country of Residence:</span> {{ $user['country_of_residence'] ?? '—' }}</p>
            {{-- أضف أي حقول أخرى حسب البيانات المُرجعة من الـ API --}}
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button
                type="submit"
                class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded"
            >
                Logout
            </button>
        </form>
    </section>
@endsection
