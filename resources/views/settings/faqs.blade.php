@extends('layouts.app')

@section('content')
    <section class="p-4 space-y-4">
        <h1 class="text-2xl font-bold">FAQs</h1>
        @forelse($faqs as $faq)
            <a href="{{ route('settings.faq.detail', $faq['id']) }}"
               class="block bg-white rounded-xl shadow p-4 hover:bg-gray-50">
                <h2 class="font-semibold">{{ $faq['question'] }}</h2>
                <p class="text-sm text-gray-500 line-clamp-2">{{ $faq['answer'] }}</p>
            </a>
        @empty
            <p class="text-center text-gray-500">لا توجد أسئلة متوفرة.</p>
        @endforelse
    </section>
@endsection
