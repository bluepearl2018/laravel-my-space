@extends('my-space::layouts.master')
@section('content')
	<x-theme::h1>
		{{ $generalTerm->title }}
		({{ __('General terms') }})
	</x-theme::h1>
	<p class="mb-2 italic">{{ $classLead }}</p>
	<div class="content-panel flex flex-col space-y-3">
		<div>
			{{$generalTerm->lead }}
		</div>
		<x-theme::h2 class="mt-4">{{__('General terms')}}</x-theme::h2>
		<div>
			{{$generalTerm->body }}
		</div>
		@auth
			@if( ! $userHasAcceptedGeneralTerms)
				<form action="{{ route('my-space.read-and-accept-general-terms', [Auth::user(), $generalTerm]) }}" method="post">
					@csrf
					<button type="submit"
							class="bg-green-500 text-gray-50 rounded-lg p-2 font-extrabold">
						{{__('Accept "My Space" General Terms') }}
					</button>
				</form>
			@endif
		@endauth
	</div>
@endsection