@component('theme::components.mails.template', ['user' => $user,
	'title' => __('Account deletion request cancelled')
])
	<p>{{ trans('Dear :user', ['user' => $user->name]) }},</p>
	<p>{!! __('We have received your request to cancel your account. Your account will not be deleted as you requested.') !!}</p>
	<p>{{__('Kind regards,')}}<br>{{ config('app.name') }}</p>
@endcomponent