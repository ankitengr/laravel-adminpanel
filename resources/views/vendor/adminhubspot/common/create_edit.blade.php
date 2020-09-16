{{-- extending the layout --}}
@extends($theme. '.layouts.adminapp')
@section('breadcamp')
  <div class="row mb-2">
    <div class="col-sm-6">
	  <h1>{{!empty($params['title']) ? $params['title'] : 'Add/Edit'}}</h1>
    </div>
    <div class="col-sm-6">
	  <ol class="breadcrumb float-sm-right">
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item active">{{!empty($params['title']) ? $params['title'] : 'Add/Edit'}}</li>
	  </ol>
    </div>
  </div>
  
@endsection


@section('content')	
	@foreach (['danger', 'warning', 'success', 'info'] as $key)
	 @if(Session::has($key))
		 <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
	 @endif
	@endforeach


	{!! Form::open(['method'=>'POST','url'=>route($params['controller'].'.store'),'files'=>true,'class'=>'form']) !!}
		@include($theme . '.common.includes.submitbutton')
		<div class="row">
			<div class="col-md-9">
			@foreach($params['fields']['left'] as $key=>$value)
				<div class="card card-primary">
				  <div class="card-header">
					<h3 class="card-title">{{ ucfirst($value->group_prop['title']) }}</h3>
					<div class="card-tools">
					  <!-- Collapse Button -->
					  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				  </div>
				  <div class="card-body">
					@foreach($value->fields as $field)
						@include($theme . '.common.includes.form')
					@endforeach
				  </div>
				</div>
			@endforeach
			</div>
			<div class="col-md-3">
			@foreach($params['fields']['right'] as $key=>$value)
				<div class="card card-primary">
				  <div class="card-header">
					<h3 class="card-title">{{ ucfirst($value->group_prop['title']) }}</h3>
					<div class="card-tools">
					  <!-- Collapse Button -->
					  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i></button>
					</div>
				  </div>
				  <div class="card-body">
					@foreach($value->fields as $field)
						@include($theme . '.common.includes.form')
					@endforeach
				  </div>
				</div>
			@endforeach
			</div>
		</div>
		
		@if(!empty($params['id']))
			{!! Form::hidden('id',$params['id']) !!}
		@endif
		@include($theme . '.common.includes.submitbutton')
	{!! Form::close() !!}
	@include($theme . '.common.includes.media_manager')
@endsection

@section('stylesheets')
	<link href="{{ asset('/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<style type="text/css">
		.fa-check,.fa-edit{color:green;cursor: pointer;}
		.fa-close,.fa-trash{color:#ff4a5a;cursor: pointer;}
	</style>
@endsection