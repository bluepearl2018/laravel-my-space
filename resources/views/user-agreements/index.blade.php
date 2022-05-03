@extends('my-space::layouts.master')
@section('content')
	<x-theme-h1>
		{{ __('User agreements') }}
	</x-theme-h1>
	<p class="mb-2 italic">{{\Eutranet\MySpace\Models\Contractable::getClassLead()}}</p>
	<div class="content-panel">
		<x-theme-h2>List</x-theme-h2>
		<ul>
			@forelse($userAgreements->get() as $agreement)
				<li>
					<a href="{!! route('my-space.' . Str::plural(\Str::slug(Str::snake(Str::afterLast($agreement->pivot->contractable_type, '\\')))).'.show', $agreement->pivot->contractable_id) !!}">
						{{$agreement->title}}
					</a>
				</li>
				@empty
			@endforelse
		</ul>
	</div>
@endsection