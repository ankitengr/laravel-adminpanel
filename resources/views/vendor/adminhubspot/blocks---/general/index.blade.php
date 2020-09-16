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
			<table class="table table-bordered" id="general-table">
			
				<thead>
					<tr>
					@foreach($columns_name as $coln)
					  <th>{{$coln}}</th>
					@endforeach
					
				  @if($isDeletePermission === true)
				  <th>Action</th>
				  @endif
					</tr>
				</thead>
			
			  <tbody>
				<?php //echo '<pre>';print_r($data);die;?>
				@foreach($data['result'] as $row)
				<tr>
					@foreach($row as $col)
						<td>{{$col}}</td>
					@endforeach
					<td>Action</td>
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
		$('#general-table').DataTable();
	  });

	</script>
@endsection




{{--


<div class="container">
    @foreach ($data as $row)
		@foreach ($row as $val)
			{{ $val }}|
		@endforeach
		<br>
    @endforeach
</div>

{{ $data->links() }}

--}}