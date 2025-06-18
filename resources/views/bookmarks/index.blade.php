@extends('layouts.app')

@section('title','المحفوظات')

@section('content')
    <div class="p-4 max-w-5xl mx-auto space-y-6">
        <h1 class="text-2xl font-bold">المحفوظات</h1>

        @if($favorites->count())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($favorites as $job)
                    <div class="bg-white rounded-xl shadow p-4 flex flex-col">
                        <div class="flex-1">
                            <h3 class="text-lg font-semibold">{{ $job->title }}</h3>
                            <p class="text-sm text-gray-600 mb-2">{{ $job->company->name }}</p>
                            <p class="text-xs text-gray-500 mb-4">
                                <span class="mr-2"><i class="fas fa-dollar-sign"></i> {{ $job->salary }}</span>
                                <span class="mr-2"><i class="fas fa-briefcase"></i> {{ $job->experience }}</span>
                            </p>
                            <p class="text-gray-700 mb-4">{{ \Illuminate\Support\Str::limit($job->description,80) }}</p>
                            <a href="{{ route('jobs.show', $job->id) }}"
                               class="text-blue-600 hover:underline text-sm">
                                عرض التفاصيل
                            </a>
                        </div>

                        {{-- إلغاء الحفظ --}}
                        <form method="POST" action="{{ route('jobs.favorite.toggle', $job->id) }}">
                            @csrf
                            <button type="submit" class="mt-4 focus:outline-none">
                                <i class="fas fa-bookmark text-xl text-red-500"></i>
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $favorites->withQueryString()->links() }}
            </div>
        @else
            <p class="text-center text-gray-600">لا توجد وظائف محفوظة لديك حالياً.</p>
        @endif
    </div>
@endsection
