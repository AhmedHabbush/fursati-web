@extends('layouts.app')

@section('title', $company->name)

@section('content')
    <div class="p-4 max-w-4xl mx-auto space-y-6">

        {{-- بانر الشركة --}}
        @if($company->banner)
            <img src="{{ $company->banner }}" alt="Banner" class="w-full h-48 object-cover rounded-lg">
        @endif

        {{-- شعار واسم الشركة --}}
        <div class="flex items-center space-x-4 mt-4">
            @if($company->logo)
                <img src="{{ $company->logo }}" alt="Logo" class="w-16 h-16 object-contain">
            @endif
            <div>
                <h1 class="text-2xl font-bold">{{ $company->name }}</h1>
                <p class="text-gray-600">{{ $company->business_type }}</p>
            </div>
        </div>

        {{-- تفاصيل إضافية --}}
        <div class="bg-white rounded-xl shadow p-4 space-y-2">
            <p><span class="font-medium">عدد الموظفين:</span> {{ $company->employees }}</p>
            <p><span class="font-medium">البلد:</span> {{ $company->country }}</p>
            <p><span class="font-medium">الهاتف:</span> {{ $company->phone }}</p>
        </div>

        {{-- نبذة عن الشركة --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h2 class="text-xl font-semibold mb-2">نبذة</h2>
            <p class="text-gray-700">{{ $company->bio }}</p>
        </div>

        {{-- قائمة الوظائف حديثة الإضافة --}}
        <div class="bg-white rounded-xl shadow p-4">
            <h2 class="text-xl font-semibold mb-4">الوظائف المتاحة</h2>

            @if($company->jobs->count())
                <ul class="space-y-3">
                    @foreach($company->jobs as $job)
                        <li class="border-b pb-3 last:border-none">
                            <a href="{{ route('jobs.show', $job->id) }}"
                               class="block hover:bg-gray-50 p-2 rounded">
                                <div class="flex justify-between">
                                    <span class="font-medium">{{ $job->title }}</span>
                                    <span class="text-xs text-gray-500">{{ $job->salary }}</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ \Illuminate\Support\Str::limit($job->description, 60) }}</p>
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-600">لا توجد وظائف متاحة حالياً.</p>
            @endif
        </div>

        {{-- زر Take Action --}}
        <div class="flex space-x-2">
            <a href="{{ route('companies.action', $company->id) }}"
               class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-2 rounded text-center">
                Take Action
            </a>
            @if($company->phone)
                <a href="tel:{{ $company->phone }}"
                   class="flex-1 bg-green-500 hover:bg-green-600 text-white py-2 rounded text-center">
                    Call
                </a>
            @endif
        </div>

    </div>
@endsection
