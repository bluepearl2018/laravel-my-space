@extends('my-space::layouts.master')
@section('content')
	<x-theme-h1>
		{{ __('User payments') }}
	</x-theme-h1>
	<p class="mb-2 italic">{{ \Eutranet\MySpace\Models\UserPayment::getClassLead() }}</p>
	<div class="content-panel">
		<x-theme-h2>List</x-theme-h2>
		<ul>
			@forelse($userPayments as $payment)
				<li>
					<a href="{!! route('my-space.user-payments.show', $payment) !!}">
						{{$payment->title}}
					</a>
				</li>
				@empty
				{{ __('NOTHING TO SHOW') }}
			@endforelse
		</ul>
	</div>
@endsection