@extends('my-space::layouts.master')
@section('content')
	<div class="flex flex-col md:flex-row justify-between">
		<div>
			<x-theme::h1>
				{{__('My social medias')}}
			</x-theme::h1>
			<p class="mb-2 italic">
				{{ \Eutranet\MySpace\Models\UserSocialMedia::getClassLead() }}
			</p>
		</div>
		<div class="items-center">
			<a href="{{ route('my-space.user-social-medias.edit', [Auth::user(), $userSocialMedias->first()]) }}" class="btn-primary">
				{{ __('Edit') }}
			</a>
		</div>
	</div>
	<div class="content-panel flex-col flex group space-y-2">
		@forelse($userSocialMedias as $key => $item)
			@if($item->blog)
				<div class="flex inline-flex items-center space-x-2">
					<i class="fa fa-globe"></i>
					<a target="_blank" href="{{ url('https://'. $item->blog) }}">{{ __('Blog or site - https://') }}{{$item->blog}}</a>
				</div>
			@endif
			@if($item->facebook)
				<div class="flex inline-flex items-center space-x-2">
					<i class="fab fa-facebook"></i>
					<a target="_blank" href="{{ url('https://www.facebook.com/' . $item->facebook) }}">{{ __('Facebook') }} ({{$item->facebook}})</a>
				</div>
			@endif
			@if($item->linkedin)
				<div class="flex inline-flex items-center space-x-2">
					<i class="fab fa-linkedin"></i>
					<a target="_blank" href="{{ url('https://www.linkedin.com/' . $item->linkedin) }}">{{ __('Linkedin') }} ({{$item->linkedin}})</a>
				</div>
			@endif
			@if($item->tiktok)
				<div class="flex inline-flex items-center space-x-2">
					<i class="fab fa-tiktok"></i>
					<a target="_blank" href="{{ url('https://www.tiktok.com/' . $item->tiktok) }}">{{ __('Tik tok') }} ({{$item->tiktok}})</a>
				</div>
			@endif
			@if($item->instagram)
				<div class="flex inline-flex items-center space-x-2">
					<i class="fab fa-instagram"></i>
					<a target="_blank" href="{{ url('https://www.instagram.com/' . $item->instagram) }}">{{ __('Instagram') }} ({{$item->instagram}})</a>
				</div>
			@endif
			@if($item->youtube)
				<div class="flex inline-flex items-center space-x-2">
					<i class="fab fa-youtube"></i>
					<a target="_blank" href="{{ url('https://www.youtube.com/' . $item->youtube) }}">{{ __('Youtube') }} ({{$item->youtube}})</a>
				</div>
			@endif
			@if($item->twitter)
				<div class="flex inline-flex items-center space-x-2">
					<i class="fab fa-twitter"></i>
					<a target="_blank" href="{{ url('https://www.twitter.com/' . $item->twitter) }}">{{ __('Twitter') }} ({{$item->twitter}})</a>
				</div>
			@endif
			@empty
		@endforelse
	</div>
@endsection