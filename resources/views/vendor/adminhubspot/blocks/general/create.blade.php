{{-- extending the layout --}}
@extends('layouts.'. $theme. '.adminapp')

@section('breadcamp')
  <div class="row mb-2">
    <div class="col-sm-6">
	  <h1>User</h1>
    </div>
    <div class="col-sm-6">
	  <ol class="breadcrumb float-sm-right">
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item">User</li>
		<li class="breadcrumb-item active">{!! (!empty($data['user'][0]->name)) ? 'Update' : 'Add' !!}</li>
	  </ol>
    </div>
  </div>
@endsection


@section('content')
	@if(session('error'))
		<div class="alert alert-danger" style="margin-top: 8px;">
			{{ session('error') }}
		</div>
	@endif

	@if(!empty($data['user'][0]->name))
		{!! Form::open(['method'=>'PATCH','url'=>route('user.update',$data['user'][0]->id),'files'=>true]) !!}
	@else	
		{!! Form::open(['method'=>'POST','url'=>route('user.store'),'files'=>true]) !!}
	@endif	
	
	<div class="card">
		<div class="card-body">
			<div class="form-group">
				{!! Form::label('name','Name :',['class'=>'form-control-label required']) !!}
				{!! Form::text('name',(!empty($data['user'][0]->name) ? $data['user'][0]->name : ''),['class'=>'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('email','Email :',['class'=>'form-control-label required']) !!}
				{!! Form::text('email',(!empty($data['user'][0]->email) ? $data['user'][0]->email : ''),['class'=>'form-control']) !!}
			</div>

			<div class="form-group">
				{!! Form::label('password','Password :',['class'=>'form-control-label required']) !!}
				{!! Form::text('password',null,['class'=>'form-control']) !!}
			</div>



			<div class="form-group">
				{!! Form::label('password','Confirm Password :',['class'=>'form-control-label required']) !!}
				{!! Form::text('confirm_password',null,['class'=>'form-control']) !!}
			</div>



			<div class="form-group">
				{!! Form::label('role','Select Role :',['class'=>'form-control-label required']) !!}
				{!! Form::select('role',$data['roleSel'],(!empty($data['user'][0]->role_id) ? $data['user'][0]->role_id : 0),['class'=>'form-control']) !!}
			</div>



			<div class="form-group">
				{!! Form::label('parent_id','Status :',['class'=>'form-control-label']) !!}
				{!! Form::select('status',array('1'=>'Active','0'=>'In-active'),(!empty($data['user'][0]->status) ? $data['user'][0]->status : 0),['class'=>'form-control']) !!}
			</div>
			
			
			<div class="form-group">
				<button class="btn btn-primary submit_control ">@if(!empty($data['user'][0]->name)) Update @else Add @endif  <span class="header_line"></span></button>
			</div>

		</div>
	</div>
	
{!! Form::close() !!}

@endsection