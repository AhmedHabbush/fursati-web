@extends('layouts.app')

@section('title', 'الإعدادات')

@section('content')
    <section class="p-4 max-w-md mx-auto space-y-6">
        <h1 class="text-2xl font-bold">الإعدادات</h1>
        <div class="space-y-3">
            <a href="{{ route('settings.faqs') }}"
               class="block bg-white shadow rounded p-4 hover:bg-gray-50 flex items-center">
                <i class="fas fa-question-circle text-blue-500 w-6"></i>
                <span class="mr-3">الأسئلة المتكررة</span>
            </a>
            <a href="{{ route('settings.policies') }}"
               class="block bg-white shadow rounded p-4 hover:bg-gray-50 flex items-center">
                <i class="fas fa-file-alt text-green-500 w-6"></i>
                <span class="mr-3">سياسة الخصوصية</span>
            </a>
            <a href="{{ route('settings.help') }}"
               class="block bg-white shadow rounded p-4 hover:bg-gray-50 flex items-center">
                <i class="fas fa-life-ring text-purple-500 w-6"></i>
                <span class="mr-3">Help & Feedback</span>
            </a>
            <a href="{{ route('settings.language') }}"
               class="block bg-white shadow rounded p-4 hover:bg-gray-50 flex items-center">
                <i class="fas fa-language text-indigo-500 w-6"></i>
                <span class="mr-3">اللغة</span>
            </a>
            <a href="{{ route('settings.notifications') }}"
               class="block bg-white shadow rounded p-4 hover:bg-gray-50 flex items-center">
                <i class="fas fa-bell text-red-500 w-6"></i>
                <span class="mr-3">التنبيهات</span>
            </a>
        </div>
    </section>
@endsection
