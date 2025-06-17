@extends('layouts.app')

@section('title', 'صفحة الوظائف')

@section('content')
    <div class="mb-6 flex items-center justify-between">
        <!-- بحث -->
        <div class="relative w-1/2">
            <input
                type="text"
                placeholder="ابحث عن وظيفة…"
                class="w-full border border-gray-300 rounded-full pl-12 pr-4 py-2
                 focus:outline-none focus:ring-2 focus:ring-blue-500"
            />
            <i class="fas fa-search absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
        </div>
        <!-- أزرار فلتر/إشعارات -->
        <div class="flex items-center space-x-4">
            <button class="p-2 ml-2 bg-white border border-gray-200 rounded-full shadow-sm hover:bg-gray-50 transition">
                <i class="fas fa-filter text-gray-600"></i>
            </button>
            <button class="relative p-2 bg-white border border-gray-200 rounded-full shadow-sm hover:bg-gray-50 transition">
                <i class="fas fa-bell text-gray-600"></i>
                <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1">
                  {{ $notificationsCount ?? 0 }}
                </span>
            </button>
        </div>
    </div>

    <!-- شبكة بطاقات الوظائف -->
    <div class="grid grid-cols-3 gap-6">
        @forelse($jobs as $job)
            <div class="group bg-white border border-gray-200 rounded-2xl shadow-sm p-6
                hover:shadow-md transition flex flex-col justify-between">
                <div>
                    <div class="flex justify-between text-xs text-gray-500 mb-2">
                        <span>{{ $job['job_time'] ?? '—' }}</span>
                        <span>{{ $job['remaining_days'] ?? '—' }} days rem.</span>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2
                       group-hover:text-blue-600 transition">
                        <a href="{{ route('jobs.show', $job['id']) }}">
                            {{ $job['title'] }}
                        </a>
                    </h3>
                    <div class="flex items-center text-gray-500 text-sm mb-3">
                        <img
                            src="{{ $job['company']['logo'] ?? 'https://via.placeholder.com/28' }}"
                            class="w-7 h-7 rounded-full ml-2"
                            alt="logo"
                        >
                        <span>{{ $job['company']['name'] }}</span>
                        <span class="mx-2">·</span>
                        <span>{{ $job['company']['views'] ?? 0 }}</span>
                    </div>
                    <div class="flex flex-wrap gap-2 text-xs">
                        @foreach($job['skills'] ?? [] as $skill)
                            <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded-full">
                                {{ $skill['title'] }}
                            </span>
                        @endforeach
                        <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded-full">
                            {{ $job['salary'] ?? '—' }}
                        </span>
                        <span class="bg-blue-50 text-blue-600 px-2 py-1 rounded-full">
                            {{ $job['experience'] ?? '—' }}
                        </span>
                    </div>
                    <p class="text-gray-500 text-sm mt-3 line-clamp-2">
                        {{ \Illuminate\Support\Str::limit($job['description'] ?? '', 80) }}
                    </p>
                </div>
                <div class="flex justify-end space-x-4 mt-4 text-gray-400 group-hover:text-gray-600 transition">
                    <button>
                        <i class="fas fa-share-alt text-lg px-2"></i>
                    </button>
                    <button>
                        <i class="fas fa-bookmark text-lg px-2"></i>
                    </button>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">لا توجد وظائف حالياً.</p>
        @endforelse
    </div>
@endsection
