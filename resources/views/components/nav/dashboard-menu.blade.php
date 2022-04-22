@auth
	<x-theme::h2>
		{{__('Custom menu')}}
	</x-theme::h2>
	<nav class="flex-1 px-2 pb-4 space-y-1">
		@auth
			@forelse(\Eutranet\MySpace\Models\DashboardMenu::all() as $item)
				{{ $item->label }}
			@empty
			@endforelse
		@endauth
	</nav>
@endauth