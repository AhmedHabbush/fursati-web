@extends('layouts.app')

@section('content')
    <section class="p-4">
        <a href="{{ route('settings.faqs') }}" class="text-blue-500 mb-4 inline-block">
            ← Back to FAQs
        </a>
        <h1 class="text-2xl font-bold mb-2">{{ $faq['question'] ?? '' }}</h1>
        <div class="bg-white rounded-xl shadow p-4 text-gray-700">
            {!! nl2br(e($faq['answer'] ?? '')) !!}
        </div>
    </section>
@endsection
