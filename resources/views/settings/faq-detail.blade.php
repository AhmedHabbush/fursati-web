@extends('layouts.app')

@section('title', 'تفاصيل السؤال')

@section('content')
    <section class="max-w-2xl mx-auto p-6 space-y-6">
        {{-- زر الرجوع --}}
        <a href="{{ route('settings.faqs') }}"
           class="inline-flex items-center text-blue-600 hover:underline">
            <i class="fas fa-arrow-right mr-2"></i>
            عودة إلى الأسئلة
        </a>

        {{-- عرض السؤال --}}
        <h1 class="text-3xl font-bold text-gray-800">
            {{ $faq->question }}
        </h1>

        {{-- عرض الإجابة --}}
        <div class="prose prose-rtl">
            {!! nl2br(e($faq->answer)) !!}
        </div>
    </section>
@endsection
