@extends('my-space::layouts.master')
@section('content')
	<div class="sm:flex sm:items-center">
		<div class="sm:flex-auto">
			<x-theme-h1>
				{{ __('Edit my Social Medias') }}
			</x-theme-h1>
			<p class="mt-2 text-md text-gray-700">{{ \Eutranet\MySpace\Models\UserSocialMedia::getClassLead() }}</p>
		</div>
		<div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
				<a href="{{ route('my-space.my-social-medias', [Auth::user(), $userSocialMedias]) }}"
			   class="inline-flex items-center justify-center rounded-md border border-transparent bg-yellow-600 px-4 py-2 text-md font-medium text-white shadow-sm hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-yellow-500 focus:ring-offset-2 sm:w-auto">
				{{ __('Show My Social medias') }}
			</a>
		</div>
	</div>
	<div class="content-panel mt-6">
		<div class="columns-2">
			<form id="my-social-medias-update-frm" method="POST"
				  action="{{ route('my-space.user-social-medias.update', ['user' => \Eutranet\MySpace\Models\MySpaceUser::find(Auth::id()), $userSocialMedias]) }}">
				@csrf
				@method('PUT')
				@foreach(\Eutranet\MySpace\Models\UserSocialMedia::getFields() as $columnName => $specs)
					<div class="break-inside-avoid-column">
						<x-dynamic-component
								:component="'theme-form-'.$specs[0].'-'.$specs[1]"
								:specs="$specs"
								:old="$userSocialMedias->$columnName"
								:columnName="$columnName"
						></x-dynamic-component>
					</div>
				@endforeach
				<x-theme-form-update-buttons form="my-social-medias-update-frm">

				</x-theme-form-update-buttons>
			</form>
		</div>
	</div>
@endsection