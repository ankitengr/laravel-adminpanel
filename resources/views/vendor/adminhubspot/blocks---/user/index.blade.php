{{-- extending the layout --}}
@extends($theme. '.layouts.adminapp')

@php 
$userObj = Auth::user();
/*$isAddPermission = $userObj->checkValidPermission($roleData,'add');
$isEditPermission = $userObj->checkValidPermission($roleData,'edit');
$isDeletePermission = $userObj->checkValidPermission($roleData,'delete');
*/

$isAddPermission = true;
$isEditPermission = true;
$isDeletePermission = true;
@endphp

@section('breadcamp')
  <div class="row mb-2">
    <div class="col-sm-6">
	  <h1>User</h1>
    </div>
    <div class="col-sm-6">
	  <ol class="breadcrumb float-sm-right">
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item active">User</li>
	  </ol>
    </div>
  </div>
  
	@if($isAddPermission === true)
	<div class="row">
	  <div class="col-sm-12">
	    <div class="float-sm-right">
	      <a href="{{ route('user.create') }}" class="btn btn-warning">Add New</a>
	    </div>
	  </div>
	</div>
	@endif
@endsection


@section('content')
	@foreach (['danger', 'warning', 'success', 'info'] as $key)
	 @if(Session::has($key))
		 <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
	 @endif
	@endforeach

	<div class="card">
		<div class="card-body">
			<table class="table table-bordered" id="user-table">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
				  <th>Email</th>
				  <th>Role</th>
				  <th>Status</th>
				  @if($isDeletePermission === true)
				  <th>Action</th>
				  @endif
					</tr>
				</thead>
			  <tbody>
				<?php //echo '<pre>';print_r($data);die;?>
				@foreach($data['result'] as $user)
				<tr>
				  <td>{{$user->id}}</td>
				  <td>
					 @if($isEditPermission === true )
						<a href="{{ route('user.edit',['id'=>$user->id])}}">{{$user->name}}</a>
					@else
					 {{$user->name}}
					@endif
					
				  </td>
				  <td>{{$user->email}}</td>
				  <td>{{$user->role}}</td>
				  <td>
					<a href="javascript:void(0)" cStats="{{$user->status}}" @if($isEditPermission === true)onclick="statusC(this,{{$user->id}},'users')" @endif> 
					  <span class="fa fa-{{$user->status == 1 ? 'check' : 'close'}}" title="{{$user->status == 1 ? 'Active' : 'Inactive'}}" class="role_status"></span>
					</a>
				  </td>
				  @if($isDeletePermission === true)
				  <td>
					<a href="javascript:void(0)" onclick="deleteC({{$user->id}},'users')"> 
					  <span class="fa fa-trash" edit-role="{{$user->id.'|users'}}" title="Edit User" class="role_status" >
					</a>
				  </td>
				  @endif
				</tr>
				@endforeach
			  </tbody>
			</table>
		</div>
	</div>
@endsection

@section('stylesheets')
	<link href="{{ asset($theme.'/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<style type="text/css">
		.fa-check,.fa-edit{color:green;cursor: pointer;}
		.fa-close,.fa-trash{color:#ff4a5a;cursor: pointer;}
	</style>
@endsection


@section('scripts')
	<script src="{{ asset($theme.'/plugins/datatables/jquery.dataTables.js') }}"></script>
	<script src="{{ asset($theme.'/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

	<script type="text/javascript">
	 
	  $(function() {
		$('#user-table').DataTable();
	  });

	</script>
@endsection