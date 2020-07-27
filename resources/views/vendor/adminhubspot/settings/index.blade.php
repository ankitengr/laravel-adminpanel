{{-- extending the layout --}}
@extends($theme. 'layouts.adminapp')
@section('breadcamp')
  <div class="row mb-2">
    <div class="col-sm-6">
    <h1>Setting</h1>
    </div>
    <div class="col-sm-6">
    <ol class="breadcrumb float-sm-right">
      <li class="breadcrumb-item"><a href="#">Home</a></li>
      <li class="breadcrumb-item active">Setting</li>
    </ol>
    </div>
  </div>
@endsection

@section('content')
  @if(session('success'))
    <div class="message success box-">
        {{ session('success') }}
    </div>
  @else
	  @foreach (['danger', 'warning', 'success', 'info'] as $key)
		@if(Session::has($key))
		<p class="alert alert-{{ $key }}">{{ Session::get($key) }}</p>
	    @endif
      @endforeach
  @endif
  <div class="card">
    <div class="card-body">
      <div class="res-table ">
      <table id="table" class="table table-striped">
        <thead>
          <tr>
          <th>Id</th>
          <th>Name</th>
           <th>Edit</th>
          <th>Status</th>
          </tr>
        </thead>
      </table>
      </div>
    </div>
  </div>
    
@endsection


@section('stylesheets')
  <link href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>

<script type="text/javascript">
         $(function() {
               $('#table').DataTable({
               processing: true,
               serverSide: true,
               ajax: '{{ route('setting_ajax_data') }}',
               columns: [
                        { data: 'id', name: 'id' },
                        { data: 'name', name: 'name' },
                        { data: 'edit', name: 'edit' },
                        { data: 'status', name: 'status' },
                     ]
            });
         });
         function checkedit(is){
          console.log(is);
          if(is=='0'){
            alert("Edit not allowed");
            return false;
          }
          else{
            return true;
          }
         }
</script>
@endsection