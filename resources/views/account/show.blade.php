@extends('my-space::layouts.master')
@section('content')
	<x-theme-h1>{{__('My account')}}</x-theme-h1>
	<p class="md:mb-4 italic">{{ \Eutranet\MySpace\Models\MySpaceUser::getClassLead() }}</p>
	<div class="content-panel">
		<div class="grid grid-cols-2 gap-8">
			<div class="flex flex-col">
				<x-theme-h2>{{__('Modificação da sua conta')}}</x-theme-h2>
				<p class="mb-4 italic">{{ __('Apart from your phone number, you are not allowed to make any change. You are accessing this page because the email address has been verified.') }}</p>
				<x-theme-form-validation-errors></x-theme-form-validation-errors>
				<form id="user-account-fields-frm" class="rounded border p-4"
					  action="{{route('my-space.my-account.update', Auth::user())}}" method="POST">
					@csrf
					@method('PUT')
					@foreach(\Eutranet\MySpace\Models\MySpaceUser::getFields() as $columnName => $specs)
						<div class="col-span-1 break-inside-avoid">
							<x-dynamic-component :component="'theme-form-'.$specs[0].'-'.$specs[1]"
												 :specs="$specs"
												 :old="$user->$columnName"
												 :columnName="$columnName">
							</x-dynamic-component>
						</div>
					@endforeach
					<div class="mt-6 block">
						<x-theme-form-update-buttons
								form="{{ 'user-account-fields-frm' }}">
						</x-theme-form-update-buttons>
					</div>
				</form>
			</div>
			<div class="flex flex-col">
				@foreach(\Eutranet\Commons\Models\UserStatus::get() as $us)
					@switch($user->user_status_id)
						@case($us->id)
						<x-theme-h2>{{__('Current user status')}}</x-theme-h2>
						<p class="mb-4">Your current user status is "{{ $us->name }}". {{ $us->description }}</p>
						@break
					@endswitch
				@endforeach
				<x-theme-h2>{{__('Terms and conditions of use')}}</x-theme-h2>
				<span class="w-full block font-extrabold">{{__('General terms')}}</span>
				@if(Auth::user()->has_accepted_general_terms_on === NULL)
					<p>
						{{ __('You haven\'t read and accepted the frontend general terms of use yet.') }}
					</p>
					<a class="btn-primary text-white">
						{{__('Read and accept frontend use general terms')}}
					</a>
				@else
					<p class="mb-4">
						{{ __('You have read and accepted the general terms of use on date ') }}
						{{ \Carbon\Carbon::createFromDate(Auth::user()->has_accepted_general_terms_on)->format('d/m/Y') }}.
						<a class="underline" href="{{ route('my-space.general-terms.show', 1) }}">
							{{ \Eutranet\Setup\Models\GeneralTerm::find(1)?->title }}
						</a>
					</p>
				@endif
				<span class="w-full block font-extrabold">{{__('My Space General terms')}}</span>
				@if(Auth::user()->has_accepted_my_space_general_terms_on ===  NULL)
					<p>
						{{ __('You haven\'t read and accepted "My Space" general terms of use yet.') }}
					</p>
					<a class="btn-primary text-white">
						{{__('Read and accept "My Space" general terms')}}
					</a>
				@else
					<p class="mb-4">
						{{ __('You have read and accepted the "My Space" general terms of use on date ') }}
						{{ \Carbon\Carbon::createFromDate(Auth::user()->has_accepted_my_space_general_terms_on)->format('d/m/Y') }}.
						<a class="underline" href="{{ route('my-space.my-space-general-terms.show', 1) }}">
							{{ \Eutranet\MySpace\Models\MySpaceGeneralTerm::find(1)?->title }}
						</a>
					</p>
				@endif
				@if(\Eutranet\Setup\Models\GeneralTerm::find(2) !== NULL)
					<x-theme-h2>{{__('GDPR, dados pessoais')}}</x-theme-h2>
					<a class="btn-primary" href="{{route('general-terms.show', 2)}}">{{__('Read our GDPR policy')}}</a>
				@endif
				@if($user->is_valid === 0)
					<x-theme-h2><i class="fa fa-exclamation-triangle text-amber-500"></i>
						{{__('Waiting for approval')}}
					</x-theme-h2>
					<p class="mb-4">{{__('As long as your account was not validated, you will not access certain advanced features.')}}</p>
				@elseif($user->is_valid === 1)
					<x-theme-h2><i class="fa fa-check-circle text-green-500 mr-2"></i>
						{{__('Your account was validated')}}
					</x-theme-h2>
					<p class="mb-4">>{{__('Your account was validated')}}</p>
				@endif
				@if($accountIsDeletable)
					<x-theme-h2 class="mt-4">{{__('Delete your account?')}}</x-theme-h2>
					<p>{{ __('As a GDPR compliant company, we allow you to delete your account.') }}</p>
					<form id="account-delete-request-frm"
						  action="{{ route('my-space.my-account.destroy', Auth::user()) }}"
						  method="post">
						@method('DELETE')
						@csrf
						<button onclick="return confirm('{{__('Sure?')}}')" type="submit"
								class="btn-primary bg-red-500" form="account-delete-request-frm">
							{{ __('Delete my account') }}
						</button>
					</form>
				@endif
				@if($accountShouldBeDeletedOn)
					<x-theme-h2 class="mt-4">{{__('Your account will be deleted')}}</x-theme-h2>
					<p>{{ __('Please note your account will be deleted') }}</p>
					<p class="p-4 bg-amber-100 text-sm">
						{{ __('We have received an account deletion request on ' . date(Auth::user()->account_deletion_request_received_on)) }}
						.
						{{__('Your account will be deleted on')}} {{$accountShouldBeDeletedOn->format('d/m/Y')}}
					</p>
					<form id="cancel-account-deletion-request-frm"
						  action="{{ route('my-space.my-account.cancel-destroy', Auth::user()) }}" method="post">
						@csrf
						<button type="submit" class="btn-primary" form="cancel-account-deletion-request-frm">
							{{ __('Cancel deletion request') }}
						</button>
					</form>
				@else

				@endif
			</div>
		</div>
	</div>
@endsection
