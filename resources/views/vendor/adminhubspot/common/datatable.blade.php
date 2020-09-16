{{-- extending the layout --}}
@extends($theme. '.layouts.adminapp')
@section('breadcamp')
  <div class="row mb-2">
    <div class="col-sm-6">
	  <h1>{{!empty($params['title']) ? $params['title'] : 'Title'}}</h1>
    </div>
    <div class="col-sm-6">
	  <ol class="breadcrumb float-sm-right">
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item active">{{!empty($params['title']) ? $params['title'] : 'Title'}}</li>
	  </ol>
    </div>
  </div>
  
	@if($params['controller']!='settings')
	<div class="row">
	  <div class="col-sm-12">
	    <div class="float-sm-right">
	      <a href="{{ route($params['controller'].'.create') }}" class="btn btn-warning">Create</a>
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
      <div class="res-table ">
      <table id="table" class="table table-striped">
        <thead>
          <tr>
          @foreach($params['fields'] as $field)
			<th>{{$field['label_text']}}</th>
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
				ajax: '{{ route($params['controller'].".index") }}',
				columns: [
					@foreach($params['fields'] as $field)
						{ data: '{{$field['column_name']}}', name: '{{$field['column_name']}}' },
					@endforeach	
                     ]
			  });
         });
</script>
@endsection