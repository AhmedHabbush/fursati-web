@extends('layouts.app')

@section('content')
    <section class="p-4 space-y-4">
        <h1 class="text-2xl font-bold mb-4">المحفوظات</h1>

        <div class="space-y-4">
            @forelse($jobs as $job)
                {{-- إعادة استخدام نفس تصميم البطاقة --}}
                <div class="bg-white rounded-xl shadow p-4 flex justify-between">
                    <div class="flex-1">
                        <div class="text-xs text-gray-500 mb-1">{{ $job['job_time'] }}</div>
                        <h3 class="text-lg font-semibold">{{ $job['title'] }}</h3>
                        <div class="flex items-center text-gray-500 text-sm mt-1">
                            <img src="{{ $job['company']['logo'] }}" class="w-6 h-6 rounded-full mr-2" alt="logo">
                            <span>{{ $job['company']['name'] }}</span>
                            <span class="mx-2">·</span>
                            <span>{{ $job['company']['views'] }}</span>
                        </div>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="bg-green-50 text-green-700 px-2 py-1 rounded-full text-xs">{{ $job['job_type']['title'] }}</span>
                            <span class="bg-green-50 text-green-700 px-2 py-1 rounded-full text-xs">{{ $job['salary'] }}</span>
                            <span class="bg-green-50 text-green-700 px-2 py-1 rounded-full text-xs">{{ $job['experience'] }}</span>
                            <span class="bg-green-50 text-green-700 px-2 py-1 rounded-full text-xs">{{ $job['remaining_days'] }}</span>
                        </div>
                        <p class="text-gray-500 text-sm mt-3 line-clamp-2">{{ Str::limit($job['description'], 80) }}</p>
                    </div>
                    <div class="flex flex-col items-center justify-between ml-4 space-y-2">
                        <button><i class="fas fa-share-alt text-gray-400 text-xl"></i></button>
                        {{-- زر إلغاء الحفظ --}}
                        <form method="POST" action="{{ route('jobs.favorite.toggle', $job['id']) }}">
                            @csrf
                            <button type="submit">
                                <i class="fas fa-bookmark text-xl text-gray-600"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-500">لا توجد وظائف محفوظة.</p>
            @endforelse
        </div>
    </section>
@endsection
