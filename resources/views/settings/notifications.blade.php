@extends('layouts.app')

@section('content')
    <section class="p-4 max-w-md mx-auto space-y-4">
        <h1 class="text-2xl font-bold">إعدادات التنبيهات</h1>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('settings.notifications.set') }}" class="space-y-4">
            @csrf

            <label class="flex items-center space-x-2">
                <input
                    type="checkbox"
                    name="notify_job_alerts"
                    value="1"
                    {{ $jobAlerts ? 'checked' : '' }}
                    class="form-checkbox"
                >
                <span>التنبيه عند توفر وظائف جديدة</span>
            </label>

            <label class="flex items-center space-x-2">
                <input
                    type="checkbox"
                    name="notify_message_alerts"
                    value="1"
                    {{ $messageAlerts ? 'checked' : '' }}
                    class="form-checkbox"
                >
                <span>التنبيه عند وصول رسالة جديدة</span>
            </label>

            <button type="submit"
                    class="mt-4 bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded">
                حفظ الإعدادات
            </button>
        </form>
    </section>
@endsection
