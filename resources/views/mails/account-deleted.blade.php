@component('theme::components.mails.template', ['user' => $user,
	'title' => __('Account deleted as requested')
])
	<p>{{ trans('Dear :user', ['user' => $user->name]) }},</p>
	<p>{!! trans('We have deleted your account as you requested.') !!}</p>
	<p>{{__('Kind regards,')}}<br>{{ config('app.name') }}</p>
@endcomponent