
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
		@if ($message = session('success'))
			<div class="alert alert-success alert-block fade in">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{!! $message !!}</strong>
			</div>
		@endif

		@if ($message = session('info'))
			<div class="alert alert-info alert-block fade in">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{{ $message }}</strong>
			</div>
		@endif

		@if ($message = session('warning'))
			<div class="alert alert-warning alert-block fade in">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{!! $message !!}</strong>
			</div>
		@endif

		@if ($message = session('danger'))
			<div class="alert alert-danger alert-block fade in">
				<button type="button" class="close" data-dismiss="alert">×</button>
				<strong>{!! $message !!}</strong>
			</div>
		@endif
		</div>
	</div>
