@extends('my-space::layouts.master')
@section('content')
	<x-theme-h1>
		{{__('My Space General Terms')}}
	</x-theme-h1>
	<p class="mb-2 italic">{{\Eutranet\MySpace\Models\MySpaceGeneralTerm::getClassLead()}}</p>
	<div class="content-panel flex flex-col">
		@forelse($mySpaceGeneralTerms->sortByDesc('created_at') as $msgt)
			<a href="{{route('my-space.my-space-general-terms.show', $msgt)}}">
				{{$msgt->title}}
			</a>
			@empty
		@endforelse
	</div>
@endsection