<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
@component('theme::components.seo-meta')@endcomponent
<body class="font-sans antialiased h-full">
<div x-data="{ sidebarOpen: false, toggle() { this.sidebarOpen = ! this.sidebarOpen } }" class="max-w-7xl mx-auto">
	<div
			x-show="sidebarOpen"
			class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true">
		<!-- Off-canvas menu overlay, show/hide based on off-canvas menu state. -->
		<div
				x-show="sidebarOpen"
				x-transition:enter="transition-opacity ease-in duration-800"
				x-transition:enter-start="opacity-0"
				x-transition:enter-end="opacity-100"
				x-transition:leave="transition-opacity ease-out duration-800 transform"
				x-transition:leave-start="opacity-100"
				x-transition:leave-end="opacity-0"
				class="fixed inset-0 z-40 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>

		<!-- Off-canvas menu, show/hide based on off-canvas menu state -->

		<div
				x-show="sidebarOpen"
				x-transition:enter="transition ease-in duration-800"
				x-transition:enter-start="-translate-x-full"
				x-transition:enter-end="translate-x-0"
				x-transition:leave="transition ease-out duration-800"
				x-transition:leave-start="translate-x-0"
				x-transition:leave-end="-translate-x-full"
				class="relative flex-1 z-40 flex flex-col max-w-xs w-full pt-5 pb-4 bg-white">

			<!--  Close button, show/hide based on off-canvas menu state. -->

			<div
					x-show="sidebarOpen"
					x-transition:enter="transition ease-in duration-300 transform"
					x-transition:enter-start="opacity-0 scale-95"
					x-transition:enter-end="opacity-100 scale-100"
					x-transition:leave="transition ease-out duration-1000 transform"
					x-transition:leave-start="opacity-100 scale-100"
					x-transition:leave-end="opacity-0 scale-95"
					class="absolute z-auto top-0 right-0 -mr-12 pt-2">
				{{-- Close sidebar button --}}
				<button
						type="button"
						@click="sidebarOpen = !sidebarOpen"
						class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
					<span class="sr-only">{{__('Close sidebar')}}</span>
					<!-- Heroicon name: outline/x -->
					<i class="fa fa-times-circle"></i>
				</button>
			</div>
			<div class="shrink-0 flex items-center px-4">
				<a href="{{ route('my-space.dashboard') }}">
					<img class="h-10 fill-current text-gray-600" src="{{ asset('images/logo.svg') }}" alt="logo"/>
				</a>
			</div>
			<div class="mt-5 flex-1 h-0 overflow-y-auto">
				<nav class="px-2 space-y-1">
					@component('my-space::components.nav.nav')@endcomponent
				</nav>
			</div>
		</div>
		<div class="flex-shrink-0 w-14" aria-hidden="true">
			<!-- Dummy element to force sidebar to shrink to fit close icon -->
		</div>
	</div>

	<!-- Static sidebar for desktop -->
	<div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
		<!-- Sidebar component, swap this element with another sidebar if you like -->
		<div class="flex flex-col flex-grow border-r border-gray-200 pt-5 bg-white overflow-y-auto">
			<div class="flex items-center flex-shrink-0 px-4">
				<a href="{{ route('my-space.dashboard') }}">
					<img class="h-8 w-auto"
						 src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}">
				</a>
			</div>
			<div class="mt-5 flex-grow flex flex-col">
				@include('my-space::components.nav.nav')
			</div>
		</div>
	</div>
	<div class="md:pl-64 flex flex-col flex-1">
		<div class="sticky top-0 z-10 flex-shrink-0 flex h-16 bg-white shadow">
			<button
					type="button"
					@click="sidebarOpen = !sidebarOpen"
					class="px-4 border-r border-gray-200 text-gray-500 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-yellow-500 md:hidden">
				<span class="sr-only">{{__('Open sidebar')}}</span>
				<!-- Heroicon name: outline/menu-alt-2 -->
				<svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
					 stroke="currentColor" aria-hidden="true">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
						  d="M4 6h16M4 12h16M4 18h7"/>
				</svg>
			</button>
			<div class="flex-1 px-4 flex justify-between">
				<div class="flex-1 flex">
					<form class="w-full flex md:ml-0" action="#" method="GET">
						<label for="search-field" class="sr-only">{{__('search.Search')}}</label>
						<div class="relative w-full text-gray-400 focus-within:text-gray-600">
							<div class="absolute inset-y-0 left-0 flex items-center pointer-events-none">
								<!-- Heroicon name: solid/search -->
								<svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
									 fill="currentColor" aria-hidden="true">
									<path fill-rule="evenodd"
										  d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
										  clip-rule="evenodd"/>
								</svg>
							</div>
							<input id="search-field"
								   class="block w-full h-full pl-8 pr-3 py-2 border-transparent text-gray-900 placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-0 focus:border-transparent sm:text-sm"
								   placeholder="Search" type="search" name="search">
						</div>
					</form>
				</div>
				<div class="ml-4 flex items-center md:ml-6">
					@auth
						<!-- User notifications -->
						@if(isset($userStatus))
							<span class="text-xs mx-4 bg-gray-100 py-1 px-2 rounded">
								{{$userStatus}}
							</span>
						@endif
						<!-- User notifications -->
						@if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
							<a href="{{ route('my-space.user-notifications.index', Auth::user()) }}">
								<i class="h-4 w-4 fa fa-bell text-red-500"></i>
							</a>
						@else
							<i class="h-4 w-4 fa fa-bell text-gray-500"></i>
						@endif

						<!-- Profile dropdown -->
						<div x-data="{ profileMenu: false }" class="ml-3 relative">
							<div>
								<button type="button"
										@click="profileMenu = !profileMenu"
										class="bg-white p-1 rounded-full text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
										id="user-menu-button" aria-expanded="false" aria-haspopup="true">
									<span class="sr-only">{{__('Open user menu')}}</span>
									<i class="h-4 w-6 fa fa-user-circle"></i>
								</button>
							</div>

							<!-- Dropdown menu, show/hide based on menu state. -->
							<div
									x-show="profileMenu"
									x-transition:enter="transition ease-out duration-100 transform"
									x-transition:enter-start="opacity-0 scale-95"
									x-transition:enter-end="opacity-100 scale-100"
									x-transition:leave="transition ease-in duration-75 transform"
									x-transition:leave-start="opacity-100 scale-100"
									x-transition:leave-end="opacity-0 scale-95"
									class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
									role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button"
									tabindex="-1">
								<!-- Active: "bg-gray-100", Not Active: "" -->
								<a href="{{route('my-space.my-profile', Auth::user())}}" class="block px-4 py-2 text-sm text-gray-700" role="menuitem"
								   tabindex="-1"
								   id="user-menu-item-0">{{__('Your Profile')}}</a>

								<form id="logout-frm" action="{{ route('logout') }}" method="post">
									@csrf
									<button form="logout-frm" type="submit"
											class="block px-4 py-2 text-sm text-gray-700"
											role="menuitem" tabindex="-1"
											id="user-menu-item-2">{{__('Logout')}}</button>
								</form>
							</div>
						</div>
					@endauth
				</div>
			</div>
		</div>
		{{-- Main content --}}
		<main class="flex-1">
			@include('theme::components.flash-message')
			<div class="py-6 bg-gray-200">
				<div class="max-w-7xl mx-auto px-4 sm:px-6 md:px-8">
					<!-- Replace with your content -->
				@yield('content')
				<!-- /End replace -->
				</div>
			</div>
		</main>
		@component('theme::partials.footer', ['model' => 'EutranetCorporateModelsCorporate'])@endcomponent
	</div>
</div>
@stack('bottom-scripts')
</body>
</html>
