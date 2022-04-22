@auth
	<nav class="px-2 space-y-1">
		<a href="{{ route('my-space.dashboard') }}"
		   class="text-gray-600 group flex items-center px-2 py-2 text-base font-medium rounded-md @if(Route::is('*dashboard*')) text-gray-900 bg-gray-100 text-gray-900 @endif">
			<i class="fa fa-home mr-2"></i>
			{{__('Dashboard')}}
		</a>
		<a href="{{route('my-space.my-account', Auth::user())}}"
		   class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(Route::is('*account*')) text-gray-900 bg-gray-100 text-gray-900 @endif">
			<i class="fa fa-user mr-2"></i>
			{{__('My account')}}
		</a>
		<a href="{{route('my-space.user-agreements.index', [Auth::user()])}}"
		   class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(Route::is('*agreements*')) bg-gray-100 text-gray-900 @endif">
			<i class="fa fa-handshake mr-2"></i>
			{{__('Agreements')}}
		</a>
		<a href="{{route('my-space.user-payments.index', [Auth::user()])}}"
		   class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(Route::is('*payments*')) bg-gray-100 text-gray-900 @endif">
			<i class="fa fa-cash-register mr-2"></i>
			{{__('Payments')}}
		</a>
		<a href="{{route('my-space.user-notifications.index', [Auth::user()])}}"
		   class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(Route::is('*user-notifications*')) text-gray-900 bg-gray-100 text-gray-900 @endif">
			<i class="fa fa-bell mr-2"></i>
			{{__('Notifications')}}
		</a>
		<a href="{{route('my-space.emails.create', [Auth::user()])}}"
		   class="text-gray-600 hover:bg-gray-50 hover:text-gray-900 group flex items-center px-2 py-2 text-sm font-medium rounded-md @if(Route::is('*emails*')) text-gray-900 bg-gray-100 text-gray-900 @endif">
			<i class="fa fa-envelope mr-2"></i>
			{{__('Contact us')}}
		</a>
	</nav>
	<div class="mt-8">
		<!-- Secondary navigation -->
		<h3 class="px-3 text-xs font-semibold text-gray-500 uppercase tracking-wider" id="desktop-teams-headline">
			{{__('My profile')}}
		</h3>
		<div class="mt-1 space-y-1" role="group" aria-labelledby="desktop-teams-headline">
			@if(Route::has('my-space.my-profile'))
				<a href="{{route('my-space.my-profile', Auth::user())}}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50">
					<span class="w-2.5 h-2.5 mr-2 bg-red-500 rounded-full" aria-hidden="true"></span>
					<span class="truncate">
						{{__('Personal info')}}
					</span>
				</a>
			@endif
			@if(Route::has('my-space.my-social-medias'))
				<a href="{{route('my-space.my-social-medias', Auth::user())}}" class="group flex items-center px-3 py-2 text-sm font-medium text-gray-700 rounded-md hover:text-gray-900 hover:bg-gray-50">
					<span class="w-2.5 h-2.5 mr-2 bg-red-500 rounded-full" aria-hidden="true"></span>
					<span class="truncate">
						{{__('Social medias')}}
					</span>
				</a>
			@endif
		</div>
	</div>
@endauth