@component('theme::components.mails.template', ['user' => $user,
	'title' => __('You are a customer: we cannot delete your account')
])
	<p>{{ trans('Dear :user', ['user' => $user->name]) }},</p>
	<p>{!! __('Unfortunately, we are unable to respond to your request: you are a customer.<br>In order to close your account, the contract between us must be terminated. Contact your manager as soon as possible.') !!}
	</p>
	<p>{{__('Kind regards,')}}<br>{{ config('app.name') }}</p>
@endcomponent