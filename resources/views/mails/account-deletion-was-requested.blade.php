@component('theme::components.mails.template', ['user' => $user,
	'title' => __('Account deletion request received')
])
	<p>{{ trans('Dear :user', ['user' => $user->name]) }},</p>
	<p>{!! trans('Without prejudice to the general terms of service and the protection of personal data, including the RGPD, your request will be exceeded within 90 days.') !!}</p>
	<p>{{__('Kind regards,')}}<br>{{ config('app.name') }}</p>
@endcomponent