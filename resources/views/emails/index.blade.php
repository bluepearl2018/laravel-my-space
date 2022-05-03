@extends('my-space::layouts.master')
@section('content')
    @auth
        <x-theme-h1>{{__('Emails you have sent')}}</x-theme-h1>
        <p class="mb-2 italic">{{__('The emails you have sent to our team are listed here.')}}</p>
        <div class="mb-4">
            @forelse(Auth::user()->emails->sortByDesc('created_at') as $email)
                <div class="w-full items-center border-dashed border-b-2 border-gray-500">
                    <span class="w-full block text-left uppercase">{!! $email->subject !!} ({{ $email->created_at->format('d-m-Y') }})</span>
                    {{ __('To') }} {{ $email->staff->name }} ({{ $email->staff->email }})
                </div>
            @empty
                {{ __('Ainda não enviou nenhuma mensagem.') }}
            @endforelse
        </div>
    @endauth
@endsection
