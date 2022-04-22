@extends('my-space::layouts.master')
@section('content')
	<x-theme::h1>
		{{__('My personal infos')}}
	</x-theme::h1>
	<p class="mb-2 italic">
		{{ \Eutranet\MySpace\Models\UserInfo::getClassLead() }}
	</p>
	<div class="flex-col flex group">

	</div>
@endsection