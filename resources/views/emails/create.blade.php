@extends('my-space::layouts.master')
@section('content')
	@auth
		<x-theme::h1>{{__('Contact a staff member')}}</x-theme::h1>
		<p class="mb-2 italic">{{__('Attach a PDF document if required.')}}</p>
		<x-theme::forms.validation-errors></x-theme::forms.validation-errors>
		<form id="send-email-frm" action="{{ route('my-space.emails.store', [Auth::user()]) }}" method="POST"
			  enctype="multipart/form-data">
			@csrf
			@foreach(\Eutranet\Setup\Models\Email::getFields() as $columnName => $specs)
				<div class="col-span-1">
					<x-dynamic-component :component="'theme::forms.'.$specs[0].'-'.$specs[1]"
										 :name="$columnName"
										 :id="Str::slug($columnName)"
										 :placeholder=" $specs[3]"
										 :required="$specs[2]"
										 :label="trans('fields.emails')"
										 :tip="$specs[4]"
										 :readonly="$specs[5] ?? NULL"
										 :model="$specs[5] ?? NULL"
										 :old="$user->$columnName"
										 :errors="$errors ?? NULL"
										 :columnName="$columnName"></x-dynamic-component>
				</div>
			@endforeach
			<input type="hidden" name="user_id" value="{{Auth::id()}}"/>
			<input type="hidden" name="from" value="{{Auth::user()->email}}"/>
			<x-theme::forms.email-buttons form="{{ __('send-email-frm') }}"></x-theme::forms.email-buttons>
		</form>
	@endauth
@endsection
@push('top-scripts')
@endpush
@push('bottom-scripts')
	<script type="text/javascript">
        $(document).ready(function () {
            $('.ckeditor').ckeditor();
        });
	</script>
@endpush
