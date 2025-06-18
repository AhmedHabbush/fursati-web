@extends('layouts.app')

@section('content')
    <div class="flex flex-col h-full">
        {{-- Header --}}
        <div class="bg-green-500 text-white p-4 flex items-center">
            <a href="{{ url()->previous() }}" class="mr-4 text-xl"><i class="fas fa-arrow-right"></i></a>
            <h2 class="text-lg font-semibold flex-1">Company Detail</h2>
        </div>

        <div class="overflow-auto p-4 space-y-6">
            {{-- Banner صورة (إن وجدت) --}}
            <img src="{{ $company['banner'] ?? 'https://via.placeholder.com/400x150' }}"
                 class="w-full h-40 object-cover rounded-lg" alt="Banner">

            {{-- Logo & الاسم --}}
            <div class="bg-white rounded-xl shadow p-4 flex items-center">
                <img src="{{ $company['logo'] ?? 'https://via.placeholder.com/48' }}"
                     class="w-12 h-12 rounded-full mr-3" alt="Logo">
                <div>
                    <div class="font-semibold">{{ $company['name'] ?? '' }}</div>
                    <div class="text-sm text-gray-500">{{ $company['id'] ?? '' }}</div>
                </div>
            </div>

            {{-- Details --}}
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <h4 class="font-semibold">Details</h4>
                <div class="text-sm text-gray-700 space-y-1">
                    <div><span class="font-medium">Type of Business:</span> {{ $company['business_type'] ?? '' }}</div>
                    <div><span class="font-medium">No. of Employees:</span> {{ $company['employees'] ?? '' }}</div>
                    <div><span class="font-medium">Country:</span> {{ $company['country'] ?? '' }}</div>
                </div>
            </div>

            {{-- BIO --}}
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <h4 class="font-semibold">BIO</h4>
                <p class="text-gray-600 text-sm">{{ $company['bio'] ?? '' }}</p>
            </div>

            {{-- Recent Jobs --}}
            <div class="bg-white rounded-xl shadow p-4 space-y-2">
                <h4 class="font-semibold">Recent Jobs</h4>
                @forelse($jobs as $job)
                    <a href="{{ route('jobs.show', $job['id']) }}"
                       class="block p-3 border rounded hover:bg-gray-50">
                        {{ $job['title'] ?? '' }}
                    </a>
                @empty
                    <p class="text-gray-500">No recent jobs.</p>
                @endforelse
            </div>

            {{-- زر Take Action --}}
            <div class="py-4">
                <a href="{{ route('companies.action', $company['id']) }}"
                   class="block bg-green-500 text-white text-center py-3 rounded-full font-semibold">
                    Take Action
                </a>
            </div>
        </div>
    </div>
@endsection
