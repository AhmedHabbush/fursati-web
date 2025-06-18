@extends('layouts.app')

@section('title', 'صفحة الوظائف')

@section('content')
    <section class="p-4" x-data="{ showFilters: false }">

        {{-- نموذج البحث --}}
        <div class="flex items-center justify-between mb-4">
            {{-- بحث --}}
            <div class="relative flex-1">
                <form method="GET" action="{{ route('jobs.index') }}">
                    <input
                        name="search"
                        type="text"
                        value="{{ request('search') }}"
                        placeholder="ابحث عن وظيفة…"
                        class="w-full bg-white rounded-full pl-10 pr-4 py-2 shadow text-sm"
                    />
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </form>
            </div>
            {{-- زر الفلترة --}}
            <button
                type="button"
                @click="showFilters = true"
                class="mx-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm"
            >
                <i class="fas fa-filter"></i>
                <span class="mr-2">فلتر</span>
            </button>

            {{-- زر إرسال البحث لوضعية mobile أو إضافي --}}
            <button
                type="submit"
                form="searchForm"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full text-sm"
            >
                بحث
            </button>
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
                    {{-- جهة اليمين: أزرار المشاركة والحفظ --}}
                    <div class="flex flex-col items-center justify-between ml-4 space-y-2">
                        {{-- زر المشاركة --}}
                        <button type="button">
                            <i class="fas fa-share-alt text-gray-400 text-xl"></i>
                        </button>

                        {{-- زر الحفظ / إلغاء الحفظ --}}
                        <form method="POST" action="{{ route('jobs.favorite.toggle', $job['id']) }}">
                            @csrf
                            <button type="submit" class="focus:outline-none">
                                <i class="{{ ($job['is_favorite'] ?? false) ? 'fas' : 'far' }} fa-bookmark text-xl text-gray-600"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-3 text-center text-gray-500">لا توجد وظائف حالياً.</p>
            @endforelse
        </div>
        {{-- فلتر مودال --}}
        <div
            x-show="showFilters"
            x-cloak
            x-transition
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50"
        >
            <div class="bg-white rounded-lg p-6 w-11/12 max-w-md" @click.away="showFilters = false">
                <h2 class="text-lg font-semibold mb-4">الفلاتر</h2>
                <form method="GET" action="{{ route('jobs.index') }}">
                    {{-- حافظ على قيمة البحث الحالية --}}
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">الدولة</label>
                        <select name="country_of_residence" class="w-full border rounded px-3 py-2">
                            <option value="">الكل</option>
                            @foreach($countries as $c)
                                <option value="{{ $c['id'] }}"
                                        @if(request('country_of_residence') == $c['id']) selected @endif>
                                    {{ $c['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- فلتر مجال العمل --}}
                    <div class="mb-4">
                        <label class="block mb-1 font-medium">مجال العمل</label>
                        <select name="work_field_id" class="w-full border rounded px-3 py-2">
                            <option value="">الكل</option>
                            @foreach($jobTypes as $t)
                                <option value="{{ $t['id'] }}"
                                        @if(request('work_field_id') == $t['id']) selected @endif>
                                    {{ $t['title'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            @click="showFilters = false"
                            class="px-4 py-2 border rounded"
                        >إلغاء
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 bg-green-500 text-white rounded"
                        >
                            تطبيق
                        </button>
                    </div>
                </form>
            </div>
        </div>
@endsection
