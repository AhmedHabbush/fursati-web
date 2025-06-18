@extends('layouts.app')
@php use Illuminate\Support\Str; @endphp

@section('title', 'صفحة الوظائف')

@section('content')
    <section class="p-4" x-data="{ showFilters: false }">

        {{-- نموذج البحث --}}
        <div class="flex items-center justify-between mb-4">
            <form id="searchForm" method="GET" action="{{ route('jobs.index') }}" class="flex-1 relative">
                <input
                    name="search"
                    type="text"
                    value="{{ request('search') }}"
                    placeholder="ابحث عن وظيفة…"
                    class="w-full bg-white rounded-full pl-10 pr-4 py-2 shadow text-sm"
                />
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </form>

            <button
                type="button"
                @click="showFilters = true"
                class="mx-2 bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-full text-sm"
            >
                <i class="fas fa-filter"></i>
                <span class="mr-2">فلتر</span>
            </button>

            <button
                type="submit"
                form="searchForm"
                class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-full text-sm"
            >
                بحث
            </button>
        </div>

        {{-- بطاقات الوظائف --}}
        @if($jobs->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($jobs as $job)
                    <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold">{{ $job->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $job->company->name }}</p>
                            <p class="text-xs text-gray-500 mb-4">
                                <span class="mr-2"><i class="fas fa-dollar-sign"></i> {{ $job->salary }}</span>
                                <span class="mr-2"><i class="fas fa-briefcase"></i> {{ $job->experience }}</span>
                            </p>
                            <p class="text-gray-700 mb-4">{{ Str::limit($job->description, 100) }}</p>
                            <a href="{{ route('jobs.show', $job->id) }}"
                               class="text-blue-600 hover:underline text-sm">
                                عرض التفاصيل
                            </a>
                        </div>

                        <div class="mt-4 flex items-center justify-between">
                            {{-- زرّ الحفظ/الإلغاء --}}
                            <form method="POST" action="{{ route('jobs.favorite.toggle', $job->id) }}">
                                @csrf
                                <button type="submit" class="focus:outline-none">
                                    <i class="
                                        {{
                                          auth()->check() && auth()->user()->favoriteJobs->contains($job->id)
                                            ? 'fas'  /* solid bookmark */
                                            : 'far'  /* outline bookmark */
                                        }} fa-bookmark
                                        text-xl
                                        text-gray-600
                                    "></i>
                                </button>
                            </form>

                            {{-- زرّ التقديم (Apply) --}}
                            <a href="#" class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-1 rounded">
                                Apply
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $jobs->withQueryString()->links() }}
            </div>
        @else
            <p class="text-center text-gray-600">لا توجد وظائف حالياً.</p>
        @endif

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
                    <input type="hidden" name="search" value="{{ request('search') }}">

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">الدولة</label>
                        <select name="country_id" class="w-full border rounded px-3 py-2">
                            <option value="">الكل</option>
                            @foreach($countries as $c)
                                <option value="{{ $c['id'] }}"
                                        @if(request('country_id') == $c['id']) selected @endif>
                                    {{ $c['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1 font-medium">مجال العمل</label>
                        <select name="job_type_id" class="w-full border rounded px-3 py-2">
                            <option value="">الكل</option>
                            @foreach($jobTypes as $t)
                                <option value="{{ $t['id'] }}"
                                        @if(request('job_type_id') == $t['id']) selected @endif>
                                    {{ $t['title'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end space-x-2">
                        <button
                            type="button"
                            @click="showFilters = false"
                            class="px-4 py-2 border rounded ml-3"
                        >
                            إلغاء
                        </button>
                        <button
                            type="submit"
                            class="px-4 py-2 ml-3 bg-green-500 text-white rounded"
                        >
                            تطبيق
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </section>
@endsection
