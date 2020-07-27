{{-- extending the layout --}}
@extends($theme. '.layouts.adminapp')
@section('breadcamp')
  <div class="row mb-2">
    <div class="col-sm-6">
	  <h1>{{!empty($header_name) ? $header_name : 'Undefined Title'}}</h1>
    </div>
    <div class="col-sm-6">
	  <ol class="breadcrumb float-sm-right">
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item active">{{!empty($header_name) ? $header_name : ''}}</li>
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
      <table id="table" class="table table-striped">
        <thead>
          <tr>
          @foreach($columns_display_name as $coln)
			<th>{{$coln}}</th>
		  @endforeach
          </tr>
        </thead>
      </table>
      </div>
    </div>
  </div>
@endsection

@section('stylesheets')
	<link href="{{ asset($resource_path ?? ''.'/plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
	<style type="text/css">
		.fa-check,.fa-edit{color:green;cursor: pointer;}
		.fa-close,.fa-trash{color:#ff4a5a;cursor: pointer;}
	</style>
@endsection

@section('scripts')
<script src="{{ asset($resource_path ?? ''.'/plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset($resource_path ?? ''.'/plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

<script type="text/javascript">
         $(function() {
               $('#table').DataTable({
				processing: true,
				serverSide: true,
				ajax: '{{ route($ajax_route) }}',
				columns: [
					@foreach($columns_name as $coln)
						{ data: '{{$coln}}', name: '{{$coln}}' },
					@endforeach	
                     ]
			  });
         });
</script>
@endsection