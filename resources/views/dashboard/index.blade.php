@extends('my-space::layouts.master')
@section('content')
	<x-theme-h1>{{__('Dashboard')}}</x-theme-h1>
	<p class="mb-4 italic">{{ __('"My space" is your working environment within the platform. Once your email address is verified and you have read and accepted the my space terms of use and services, you have access to the basic features.') }}</p>
	<div class="rounded-lg bg-gray-200 overflow-hidden shadow divide-y divide-gray-200 sm:divide-y-0 sm:grid sm:grid-cols-2 sm:gap-px md:gap-6">
		{{--Account --}}
		<div class="relative group bg-white p-6 focus-within:ring-4 focus-within:ring-inset focus-within:ring-yellow-500">
			<div>
				<i class="fa fa-user-circle fa-2x text-yellow-500"></i>
			</div>
			<div class="mt-4">
				@auth
				<x-theme-h1 class="text-lg font-medium">
					<a href="{{route('my-space.my-account', Auth::user())}}" class="focus:outline-none">
						<!-- Extend touch target to entire panel -->
						<span class="absolute inset-0" aria-hidden="true"></span>
						{{ __('My account') }}
					</a>
				</x-theme-h1>
				@endauth
				<p class="mt-2 text-sm text-gray-500">
					{{__('Your personal data is associated with your user account. Unless otherwise expressly agreed by contract, you may request the deletion of your account at any time.') }}
				</p>
			</div>
			<span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
				  aria-hidden="true">
                <i class="fa fa-arrow-right text-2xl"></i>
            </span>
		</div>
		{{--Notifications --}}
		<div class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-yellow-500">
			<div>
				<i class="fa fa-bell fa-2x text-yellow-500"></i>
			</div>
			<div class="mt-4">
				<x-theme-h1 class="text-lg font-medium">
					<a href="{{route('my-space.user-notifications.index', [Auth::user()])}}" class="focus:outline-none">
						<!-- Extend touch target to entire panel -->
						<span class="absolute inset-0" aria-hidden="true"></span>
						{{__('Notifications')}}
					</a>
				</x-theme-h1>
				<p class="mt-2 text-sm text-gray-500">
					{{__('The notification service allows the exchange of messages internally, between account holders. When user-notifications are urgent, they are accompanied by an email.')}}
				</p>
			</div>
			<span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
				  aria-hidden="true">
                <i class="fa fa-arrow-right text-2xl"></i>
            </span>
		</div>
		@if(Route::has('my-space.contact-attempts.index'))
			{{--Contact attempts --}}
			<div class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-yellow-500">
				<div>
					<i class="fa fa-phone fa-2x text-yellow-500"></i>
				</div>
				<div class="mt-4">
					<x-theme-h1 class="text-lg font-medium">
						<a href="{{route('my-space.contact-attempts.index', [Auth::user()])}}" class="focus:outline-none">
							<!-- Extend touch target to entire panel -->
							<span class="absolute inset-0" aria-hidden="true"></span>
							{{__('contact-attempts.Contact attempts')}}
						</a>
					</x-theme-h1>
					<p class="mt-2 text-sm text-gray-500">
						{{__('A list of successful and unsuccessful attempts by our staff to contact you are included in this list. The time is indicated. When the phone is red, it means that we have not been able to reach you. ')}}
					</p>
				</div>
				<span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
					  aria-hidden="true">
					<i class="fa fa-arrow-right text-2xl"></i>
				</span>
			</div>
		@endif
		@if(Route::has('my-space.consultations.index'))
			{{--Consultations --}}
			<div class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-yellow-500">
				<div>
					<i class="fa fa-calendar-alt fa-2x text-yellow-500"></i>
				</div>
				<div class="mt-4">
					<x-theme-h1 class="text-lg font-medium">
						<a href="{{route('my-space.consultations.index', [Auth::user()])}}" class="focus:outline-none">
							<!-- Extend touch target to entire panel -->
							<span class="absolute inset-0" aria-hidden="true"></span>
							{{__('labels.Consultations')}}
						</a>
					</x-theme-h1>
					<p class="mt-2 text-sm text-gray-500">
						{{__('A list of past and future consultations, with location, date and time, and your case manager. Find the briefing of the consultation, so that you do not forget anything.')}}
					</p>
				</div>
				<span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
					  aria-hidden="true">
					<i class="fa fa-arrow-right text-2xl"></i>
				</span>
			</div>
		@endif
		@if(Route::has('my-space.user-agreements.index'))
			{{--Agreements --}}
			<div class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-yellow-500">
				<div>
					<i class="fa fa-handshake fa-2x text-yellow-500"></i>
				</div>
				<div class="mt-4">
					<x-theme-h1 class="text-lg font-medium">
						<a href="{{route('my-space.user-agreements.index', [Auth::user()])}}" class="focus:outline-none">
							<!-- Extend touch target to entire panel -->
							<span class="absolute inset-0" aria-hidden="true"></span>
							{{__('Agreements')}}
						</a>
					</x-theme-h1>
					<p class="mt-2 text-sm text-gray-500">
						{{__('A list of the contracts we have concluded, together with the related annexes.')}}
					</p>
				</div>
				<span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
					  aria-hidden="true">
					<i class="fa fa-arrow-right text-2xl"></i>
				</span>
			</div>
		@endif
		{{--Bills --}}
		<div class="relative group bg-white p-6 focus-within:ring-2 focus-within:ring-inset focus-within:ring-yellow-500">
			<div>
				<i class="fa fa-cash-register fa-2x text-yellow-500"></i>
			</div>
			<div class="mt-4">
				<x-theme-h1 class="text-lg font-medium">
					<a href="{{route('my-space.user-payments.index', [Auth::user()])}}" class="focus:outline-none">
						<!-- Extend touch target to entire panel -->
						<span class="absolute inset-0" aria-hidden="true"></span>
						{{__('Bills')}}
					</a>
				</x-theme-h1>
				<p class="mt-2 text-sm text-gray-500">
					{{__('The list of invoices we have sent you')}}
				</p>
			</div>
			<span class="pointer-events-none absolute top-6 right-6 text-gray-300 group-hover:text-gray-400"
				  aria-hidden="true">
                <i class="fa fa-arrow-right text-2xl"></i>
            </span>
		</div>
	</div>
@endsection
