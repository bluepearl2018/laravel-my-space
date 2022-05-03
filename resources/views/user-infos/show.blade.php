@extends('my-space::layouts.master')
@section('content')
	<x-theme-h1>
		{{__('My personal infos')}}
	</x-theme-h1>
	<p class="mb-2 italic">
		{{ \Eutranet\MySpace\Models\UserInfo::getClassLead() }}
	</p>
	<div class="col-span-full">
		<div class="w-full">
			<div class="flex flex-col divide-y divide-gray-300">
				@forelse(collect($userInfo->getFields()) as $key => $field)
					<div class="align-text-top flex flex-row items-center gap-4">
						<div class="w-1/3 table-cell font-semibold bg-gray-300 px-4">
							{{ $field[3] }}
						</div>
						@if($field[0] === 'select')
							<div>{!! $field[5]::where('id', $userInfo->$key)->get()->first() ? $field[5]::where('id', $userInfo->$key)->get()->first()->name : '<i class="fa fa-times text-red-500"></i>' !!} </div>
						@else
							<div>{!! $userInfo->$key ?: '<i class="fa fa-times text-red-500"></i>' !!} </div>
						@endif
					</div>
				@empty
				@endforelse
			</div>
		</div>
	</div>
@endsection