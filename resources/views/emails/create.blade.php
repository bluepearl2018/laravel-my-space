@extends('my-space::layouts.master')
@section('content')
	@auth
		<x-theme-h1>{{__('Contact a staff member')}}</x-theme-h1>
		<p class="mb-2 italic">{{__('Attach a PDF document if required.')}}</p>
		<x-theme-form-validation-errors></x-theme-form-validation-errors>
		<form id="send-email-frm" action="{{ route('my-space.emails.store', [Auth::user()]) }}" method="POST"
			  enctype="multipart/form-data">
			@csrf
			@foreach(\Eutranet\Setup\Models\Email::getFields() as $columnName => $specs)
				<div class="col-span-1 break-inside-avoid">
					<x-dynamic-component :component="'theme-form-'.$specs[0].'-'.$specs[1]"
										 :specs="$specs"
										 old="{{old($columnName)}}"
										 :columnName="$columnName">
					</x-dynamic-component>
				</div>
			@endforeach
			<input type="hidden" name="user_id" value="{{Auth::id()}}"/>
			<input type="hidden" name="from" value="{{Auth::user()->email}}"/>
			<x-theme-form-email-buttons form="{{ __('send-email-frm') }}"></x-theme-form-email-buttons>
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
