@extends('setup::layouts.master')
@section('content')
	<h1 class="text-4xl">{{__('Laravel My Space Configuration')}}</h1>
	<p class="mb-2 italic">{{__('Package info')}}</p>
	<div class="table w-full">
		@forelse(config('eutranet-my-space.models') as $model)
			<div class="flex flex-row align-top align-text-top mb-4 border-b-2 justify-between">
				<div class="lg:table-cell">
					<x-theme-h2	class="border-b-0">
						@if(Schema::hasTable(Str::plural(\Str::snake($model))) === 1)
							<i class="fa fa-times text-red-500 mr-2"></i>
						@else
							<i class="fa fa-check text-green-500 mr-2"></i>
						@endif
						{{ $model }}
					</x-theme-h2>
					@if(class_exists('Eutranet\\MySpace\\Models\\'.$model))
						@php $class = 'Eutranet\\MySpace\\Models\\'.$model @endphp
						@if($class::getClassLead() !== NULL && !empty($class::getClassLead()))
							{{$class::getClassLead()}}
						@else
						@endif
					@else
						<i class="fa fa-exclamation-triangle text-red-500 mr-2"></i>{{ Str::studly($model)}} class is missing
					@endif
				</div>
				<div class="lg:table-cell text-right">
					<a href="{{route('setup.' . Str::plural(Str::slug(Str::snake($model))) . '.index')}}" class=""><i class="fa fa-cogs text-gray-500"></i></a>
				</div>
			</div>
		@empty
		@endforelse
	</div>
@endsection