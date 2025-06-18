{{-- resources/views/jobs/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto space-y-6">

        {{-- بيانات أساسيّة --}}
        <h1 class="text-2xl font-bold">{{ $job->title }}</h1>
        <p class="text-gray-600">{{ $job->company->name }}</p>

        {{-- Salary & Experience --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <div class="font-medium">Salary / Wage</div>
                <div>{{ $job->salary }}</div>
            </div>
            <div>
                <div class="font-medium">Required Experience</div>
                <div>{{ $job->experience }}</div>
            </div>
        </div>

        {{-- Skills --}}
        <div class="bg-white p-4 rounded shadow">
            <h4 class="font-semibold mb-2">Skills</h4>
            <div class="flex flex-wrap gap-2">
                @foreach($job->skills as $skill)
                    {{-- إذا كانت المهارة مصفوفة تحتوي على مفتاح title --}}
                    @if(is_array($skill) && isset($skill['title']))
                        <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs">
                            {{ $skill['title'] }}
                        </span>
                    @else
                        {{-- وإلّا نفترضها نصّاً --}}
                        <span class="bg-green-50 text-green-700 px-3 py-1 rounded-full text-xs">
                          {{ $skill }}
                        </span>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Description --}}
        <div class="bg-white p-4 rounded shadow">
            <h4 class="font-semibold mb-2">Job Description</h4>
            <p class="text-gray-600 text-sm">{{ $job->description }}</p>
        </div>

        {{-- Candidate Requirements --}}
        <div class="bg-white p-4 rounded shadow">
            <h4 class="font-semibold mb-2">Candidate Requirements</h4>
            <p>Nationality: {{ implode(', ', $job->nationalities ?? []) }}</p>
            <p>Country Residence: {{ implode(', ', $job->residences ?? []) }}</p>
            <p>Gender: {{ $job->gender }}</p>
        </div>

        <a href="#" class="inline-block bg-teal-500 text-white px-6 py-3 rounded">Apply</a>
    </div>
@endsection
