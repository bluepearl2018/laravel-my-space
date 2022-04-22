@component('theme::components.mails.template', ['user' => $user,
	'title' => __('Your account was locked')
])
	<p>{{ trans('Dear :user', ['user' => $user->name]) }},</p>
	<p>{{__('Your account was locked.')}}</p>
	<p>{{__('Kind regards,')}}<br>{{ config('app.name') }}</p>
@endcomponent