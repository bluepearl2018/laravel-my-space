@component('theme::components.mails.template', ['user' => $user,
	'title' => __('Your account was validated')
])
	<p>{{ trans('Dear :user', ['user' => $user->name]) }},</p>
	<p>{{__('Our team was able to carry out some checks and validated your account.
		Access your space to follow the progress of your case.')}}</p>
	<p>{{__('Kind regards,')}}<br>{{ config('app.name') }}</p>
@endcomponent