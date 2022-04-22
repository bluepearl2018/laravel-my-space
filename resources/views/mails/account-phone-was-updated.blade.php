@component('theme::components.mails.template', [
	'user' => $user,
	'title' => __('Account phone number was updated')
])
	<p>{{ trans('Dear :user', ['user' => $user->name]) }},</p>
	<p>{!! trans('The phone number associated with your account has been updated.') !!}</p>
	<p>{{__('Kind regards,')}}<br>{{ config('app.name') }}</p>
@endcomponent