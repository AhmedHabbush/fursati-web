@extends('layouts.app')

@section('content')
    <section class="p-4 max-w-lg mx-auto space-y-6">
        <h1 class="text-2xl font-bold">My Profile</h1>

        <div class="bg-white rounded-xl shadow p-4 space-y-2">
            <p><span class="font-medium">Name:</span> {{ $user->name }}</p>
            <p><span class="font-medium">Email:</span> {{ $user->email }}</p>
        </div>

        {{-- الوظائف المحفوظة --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h2 class="font-semibold mb-2">Saved Jobs</h2>
            @forelse($user->favoriteJobs as $job)
                <div class="mb-2">
                    <a href="{{ route('jobs.show', $job->id) }}" class="text-blue-600">
                        {{ $job->title }} at {{ $job->company->name }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">No saved jobs.</p>
            @endforelse
        </div>

        {{-- الوظائف المتقدّم لها --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h2 class="font-semibold mb-2">Applied Jobs</h2>
            @forelse($user->appliedJobs as $job)
                <div class="mb-2">
                    <a href="{{ route('jobs.show', $job->id) }}" class="text-blue-600">
                        {{ $job->title }} at {{ $job->company->name }}
                    </a>
                </div>
            @empty
                <p class="text-gray-500">No applications yet.</p>
            @endforelse
        </div>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="w-full bg-red-500 hover:bg-red-600 text-white py-2 rounded">
                Logout
            </button>
        </form>
    </section>
@endsection
