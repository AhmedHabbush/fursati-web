@extends('layouts.app')

@section('content')
    <section class="p-4 space-y-4">
        <h1 class="text-2xl font-bold">Privacy Policy</h1>
        @forelse($policies as $policy)
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <h2 class="font-semibold">{{ $policy['title'] }}</h2>
                {!! nl2br(e($policy['content'])) !!}
            </div>
        @empty
            <p class="text-center text-gray-500">لا توجد سياسات للعرض.</p>
        @endforelse
    </section>
@endsection
