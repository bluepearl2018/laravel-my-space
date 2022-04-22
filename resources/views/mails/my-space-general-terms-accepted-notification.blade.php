@component('theme::components.mails.template', ['user' => $user,
	'title' => __('You accepted "My Space" general terms')
])
	<p>{{ trans('Dear :user', ['user' => $user->name]) }},</p>
	<p>{{__('You have accepted the latest version of the general conditions of use of "My space".')}}</p>
	<p>{{__('Kind regards,')}}<br>{{ config('app.name') }}</p>
@endcomponent