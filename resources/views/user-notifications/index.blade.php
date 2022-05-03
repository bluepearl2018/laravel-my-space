@extends('my-space::layouts.master')
@section('content')
	<x-theme-h1>{{__('Notifications')}}</x-theme-h1>
	<p class="mb-2 italic">{{__('List of unread user-notifications.')}}</p>
	<div class="content-panel space-y-2">
		@forelse($userNotifications as $notification)
			<div class="flex group flex-row items-center justify-between ">
				<div>
					<li>
						<a href="" data-notif-id="{{$notification->id}}">
							{{ $notification->data['title'] }}
						</a>
					</li>
{{--					{{ Str::replace('Notification', ' ', (Str::title(Str::replace('_', ' ', Str::snake(\Str::afterLast($notification->type, '\\')))))) }}--}}
				</div>
				<form class="w-1/5" action="{{  $notification->markAsRead() }}">
					{{ csrf_field() }}
					{{ method_field('PUT') }}
					<input type="submit" class="btn-primary m-0 bg-green-500" value="{{ __('Mark as read') }}">
				</form>
			</div>
		@empty
			{{__('Nothing to show')}}
		@endforelse
	</div>
@endsection