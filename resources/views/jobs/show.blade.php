@extends('layouts.app')

@section('content')
    <div class="flex flex-col h-full">
        {{-- الهيدر --}}
        <div class="bg-green-500 text-white p-4 flex items-center">
            <a href="{{ url()->previous() }}" class="mr-4 text-xl">
                <i class="fas fa-arrow-right"></i>
            </a>
            <h2 class="text-lg font-semibold flex-1">تفاصيل الوظيفة</h2>
        </div>

        <div class="overflow-auto p-4 space-y-6">
            {{-- بطاقة العنوان والزمن والشركة --}}
            <div class="bg-white rounded-xl shadow p-4 flex justify-between items-start">
                <div class="flex-1">
                    <div class="text-xs text-gray-500">{{ $job['job_time'] ?? '' }}</div>
                    <h3 class="text-xl font-bold">{{ $job['title'] ?? '' }}</h3>
                    <div class="flex items-center text-gray-600 mt-1">
                        <img src="{{ $job['company']['logo'] ?? '' }}"
                             class="w-8 h-8 rounded-full mr-2" alt="logo">
                        <div>
                            <div class="font-medium">{{ $job['company']['name'] ?? '' }}</div>
                            <div class="text-sm text-gray-500">{{ $job['company']['views'] ?? '' }} views</div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col space-y-2 ml-4">
                    <button><i class="fas fa-share-alt text-gray-400 text-2xl"></i></button>
                    <button><i class="fas fa-bookmark text-gray-400 text-2xl"></i></button>
                </div>
            </div>

            {{-- التفاصيل --}}
            <div class="bg-white rounded-xl shadow p-4 space-y-4">
                <h4 class="font-semibold">Details</h4>
                <div class="grid grid-cols-2 gap-4 text-sm text-gray-700">
                    <div>
                        <div class="font-medium">Job Type</div>
                        <div>{{ $job['job_type']['title'] ?? '' }}</div>
                    </div>
                    <div>
                        <div class="font-medium">Work Field</div>
                        <div>{{ $job['job_type']['title'] ?? '' }}</div>
                    </div>
                    <div>
                        <div class="font-medium">Country</div>
                        <div>{{ $job['country_of_employment'] ?? '' }}</div>
                    </div>
                    <div>
                        <div class="font-medium">Salary / Wage</div>
                        <div>{{ $job['salary'] ?? '' }}</div>
                    </div>
                    <div>
                        <div class="font-medium">Required Experience</div>
                        <div>{{ $job['experience'] ?? '' }}</div>
                    </div>
                </div>
            </div>

            {{-- المهارات --}}
            <div class="bg-white rounded-xl shadow p-4">
                <h4 class="font-semibold mb-2">Skills</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($job['skills'] ?? [] as $skill)
                        <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs">
            {{ $skill['title'] }}
          </span>
                    @endforeach
                </div>
            </div>

            {{-- الوصف --}}
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <h4 class="font-semibold">Job Description</h4>
                <p class="text-gray-600 text-sm">{{ $job['description'] ?? '' }}</p>
            </div>

            {{-- متطلبات المتقدم --}}
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <h4 class="font-semibold">Candidate Requirements</h4>
                <div class="text-sm text-gray-700">
                    <div><span class="font-medium">Nationality:</span> {{ implode(', ', $job['candidate_nationality'] ?? []) }}</div>
                    <div><span class="font-medium">Country Residence:</span> {{ implode(', ', $job['candidate_residence'] ?? []) }}</div>
                    <div><span class="font-medium">Gender:</span> {{ $job['candidate_gender'] ?? '' }}</div>
                </div>
            </div>

            {{-- زر التقديم --}}
            <div class="py-4">
                <a href="#" class="block bg-green-500 text-white text-center py-3 rounded-full font-semibold">
                    Apply
                </a>
            </div>
        </div>
    </div>
@endsection
