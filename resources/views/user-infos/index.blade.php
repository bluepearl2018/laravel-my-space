@extends('setup::layouts.master')
@section('content')
	<x-theme-h1>{{__('User infos')}}</x-theme-h1>
	<p class="mb-2 italic">{{ Eutranet\MySpace\Models\UserInfo::getClassLead() }}</p>
	<div class="flex flex-col items-start">
		@forelse(Eutranet\MySpace\Models\UserInfo::all() as $userInfo)
			<div class="flex flex-row text-left w-full">
				<a href="{{route('my-space.user-infos.show', [$userInfo->user, $userInfo])}}">{{$userInfo->user->name}}</a>
			</div>
		@empty
		@endforelse
	</div>
@endsection