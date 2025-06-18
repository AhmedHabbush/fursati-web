@extends('layouts.app')

@section('content')
    <div class="p-4 space-y-6">
        <h2 class="text-lg font-semibold">Take Action</h2>

        <div class="bg-white rounded-xl shadow p-4 space-y-3">
            {{-- Call --}}
            <a href="tel:{{ $company['phone'] ?? '' }}"
               class="flex items-center p-3 border rounded hover:bg-gray-50">
                <i class="fas fa-phone-alt text-green-500 mr-3"></i>Call
            </a>

            {{-- Send SMS --}}
            <a href="sms:{{ $company['phone'] ?? '' }}"
               class="flex items-center p-3 border rounded hover:bg-gray-50">
                <i class="fas fa-sms text-green-500 mr-3"></i>Send SMS
            </a>

            {{-- WhatsApp --}}
            <a href="https://wa.me/{{ preg_replace('/\D/','',$company['phone'] ?? '') }}"
               class="flex items-center p-3 border rounded hover:bg-gray-50">
                <i class="fab fa-whatsapp text-green-500 mr-3"></i>WhatsApp
            </a>
        </div>
    </div>
@endsection
