@extends('my-space::layouts.master')
@section('content')
	@auth
		@if(isset($contactAttempts))
		<x-theme-h1>{{__('contact-attempts.Contact attempts')}}</x-theme-h1>
		<p class="mb-2 italic">{{__('When our staff tried to contact you.')}}</p>
		<div class="content-panel">
			@forelse($contactAttempts->sortByDesc('created_at') as $ca)
				<div class="w-full flex flex-row items-center">
					{!! $ca->success === 1 ? '<i class="fa fa-check text-green-500 mr-2"></i>' : '<i class="fa fa-exclamation-triangle text-red-500 mr-2"></i>' !!}
					{{ $ca->created_at->format('d-m-Y') }} {{ __('Contacted by') }}
					{{ $ca->staff->name }} ({{ $ca->staff->email }})
				</div>
			@empty
				{{ __('Our staff will try to contact you soon.') }}
			@endforelse
		</div>
		@else
			{{ __('No contact attempts to show') }}
		@endif
	@endauth
@endsection
