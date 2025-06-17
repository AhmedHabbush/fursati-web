@extends('layouts.app')

@section('title', 'صفحة الوظائف')

@section('content')
    <section class="p-4" x-data="{ showFilters: false }">

        {{-- نموذج البحث --}}
        <form method="GET" action="{{ route('jobs.index') }}" class="flex items-center mb-4">
            <div class="relative flex-1">
                <input
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="ابحث عن وظيفة…"
                    class="w-full bg-white rounded-full pl-10 pr-4 py-2 shadow text-sm"
                />
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
            <button
                type="button"
                @click="showFilters = true"
                class="ml-2 text-xl text-gray-600"
            ><i class="fas fa-filter"></i></button>
            <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-full">بحث</button>
        </form>

        {{-- فلتر مودال --}}
        <div
            x-show="showFilters"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center"
        >
            <div class="bg-white rounded-lg p-6 w-11/12 max-w-md" @click.away="showFilters = false">
                <h2 class="text-lg font-semibold mb-4">الفلاتر</h2>
                <form method="GET" action="{{ route('jobs.index') }}">
                    {{-- حافظ على قيمة البحث الحالية --}}
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <div class="mb-4">
                        <label class="block mb-1">الدولة</label>
                        <select name="country" class="w-full border rounded px-3 py-2">
                            <option value="">الكل</option>
                            @foreach($countries as $c)
                                <option value="{{ $c }}" @if(request('country')==$c) selected @endif>
                                    {{ $c }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">مجال العمل</label>
                        <select name="job_type_id" class="w-full border rounded px-3 py-2">
                            <option value="">الكل</option>
                            @foreach($jobTypes as $id => $type)
                                <option value="{{ $id }}" @if(request('job_type_id')==$id) selected @endif>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            @click="showFilters = false"
                            class="px-4 py-2 rounded border"
                        >إلغاء</button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded"
                        >تطبيق</button>
                    </div>
                </form>
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
