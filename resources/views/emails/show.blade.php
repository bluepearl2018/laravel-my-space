@extends('my-space::layouts.master')
@section('content')
    @auth
        <x-theme-h1>
            <span class="flex flex-col">
                {{__('Email details')}}
            </span>
        </x-theme-h1>
        <div class="flex flex-col bg-gray-300 border border-gray-400 px-4 py-8">
            <x-theme-h2 class="mb-2 text-lg bg-yellow-100 px-2">
                {{__('Subject')}} : <strong>{{ $email->subject  }}</strong>
            </x-theme-h2>
            <div>From : {{ $email->user->name }} ({{ $email->user->email }})</div>
            <div>To : {{ $email->staff->name }}</div>
            <div>{{ __('Created on') }} {{ $email->created_at->format('d-m-Y') }} {{ __('at')  }} {{ $email->created_at->format('H:i:s') }}</div>
            <div class="bg-white p-4 prose max-w-prose my-4">
                {!! $email->message_body  !!}
            </div>
            @if($mediaItems->count() > 0)
                <x-theme-h2>{{ __('labels.Attachments') }} {{ '(PDF, PNG, JPEG)' }}</x-theme-h2>
                <p class="italic mb-2">{{ __('Ficheiros anexados não são descarregaveis.') }}</p>
                @foreach($mediaItems as $mediaItem)
                    <span><i class="fa fa-download mr-2"></i>{{ $mediaItem->name }}</span>
                @endforeach
                @else
                <p class="my-2"><i class="fa fa-exclamation-circle text-yellow-600 mr-2"></i>{{ __('No attachment found') }}</p>
            @endif
        </div>
    @endauth
@endsection
