@extends('my-space::layouts.master')
@section('content')
	<x-theme::h1>
		{{ $mySpaceGeneralTerm->title }}
		({{ __('General terms') }})
	</x-theme::h1>
	<p class="mb-2 italic">{{ \Eutranet\MySpace\Models\MySpaceGeneralTerm::getClassLead() }}</p>
	<div class="content-panel flex flex-col space-y-3">
		<div>
			{{$mySpaceGeneralTerm->lead }}
		</div>
		<x-theme::h2 class="mt-4">{{__('General terms')}}</x-theme::h2>
		<div>
			{{$mySpaceGeneralTerm->body }}
		</div>
		@auth
			@if( ! $userHasAcceptedMySpaceGeneralTerms)
				<form action="{{ route('my-space.read-and-accept-my-space-general-terms', [Auth::user(), $mySpaceGeneralTerm]) }}" method="post">
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