{{-- extending the layout --}}
@extends($theme. '.layouts.adminapp')
@section('breadcamp')
  <div class="row mb-2">
    <div class="col-sm-6">
	  <h1>{{!empty($title) ? $title : 'Undefined Title'}}</h1>
    </div>
    <div class="col-sm-6">
	  <ol class="breadcrumb float-sm-right">
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item active">{{!empty($title) ? $title : ''}}</li>
	  </ol>
    </div>
  </div>
  
	<div class="row">
	  <div class="col-sm-12">
	    <div class="float-sm-right">
	      <a href="" class="btn btn-warning">Add New</a>
	    </div>
	  </div>
	</div>
@endsection


@section('content')
	@foreach (['danger', 'warning', 'success', 'info'] as $key)
	 @if(Session::has($key))
		 <p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
	 @endif
	@endforeach

	<div class="card">
    <div class="card-body">
      <div class="res-table ">
		<div id="table_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="dataTables_length" id="table_length">
						<label>Show <select name="table_length" aria-controls="table" class="custom-select custom-select-sm form-control form-control-sm"><option value="10">10</option><option value="25">25</option><option value="50">50</option><option value="100">100</option></select> entries</label>
					</div>
				</div>
				<div class="col-sm-12 col-md-6"><div id="table_filter" class="dataTables_filter"><label>Search:<input type="search" class="form-control form-control-sm" placeholder="" aria-controls="table"></label></div></div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<table id="table" class="table table-striped dataTable no-footer" role="grid" aria-describedby="table_info" style="width: 1020px;">
						<thead>
							<tr role="row">
								@foreach($columns_name as $coln)
								<th>{{$coln}}</th>
								@endforeach
							</tr>
						</thead>
						<tbody>
							@foreach($data['result'] as $row)
							<tr role="row" class="odd">
								@foreach($row as $key=>$val)
								<td>{{$val}}</td>
								@endforeach
							</tr>
							@endforeach
						</tbody>
					</table>
					<div id="table_processing" class="dataTables_processing card" style="display: none;">Processing...</div>
				</div>
			</div>
			<div class="row"><div class="col-sm-12 col-md-5"><div class="dataTables_info" id="table_info" role="status" aria-live="polite">Showing 1 to 1 of 1 entries</div></div><div class="col-sm-12 col-md-7">
			<div class="dataTables_paginate paging_simple_numbers" id="table_paginate">
			{{ $data['result']->links()}}
			</div></div></div>
		</div>
      </div>
    </div>
  </div>
@endsection

@section('stylesheets')
	<link href="{{ asset($resource_path.'/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<style type="text/css">
		.fa-check,.fa-edit{color:green;cursor: pointer;}
		.fa-close,.fa-trash{color:#ff4a5a;cursor: pointer;}
	</style>
@endsection

