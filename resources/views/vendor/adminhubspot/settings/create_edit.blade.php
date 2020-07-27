{{-- extending the layout --}}
@extends($theme. '.layouts.adminapp')

@section('stylesheets')
<link href="{{ asset('/plugins/datetimepicker/datetimepicker.min.css') }}" rel="stylesheet">
<link href="{{ asset('/plugins/fselect/fSelect.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<!-- daterangepicker -->
<script src="{{ asset('/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('/plugins/datetimepicker/datetimepicker.full.min.js') }}"></script>
<script src="{{ asset('/plugins/fselect/fSelect.js') }}"></script>
@endsection

@section('breadcamp')
<div class="row mb-2">
  <div class="col-sm-6">
	<h1>{{ $option_key }}</h1>
  </div>
  <div class="col-sm-6">
	<ol class="breadcrumb float-sm-right">
	  <li class="breadcrumb-item"><a href="#">Home</a></li>
	  <li class="breadcrumb-item"><a href="{{ route('settings.index')}}">Settings</a></li>
	  <li class="breadcrumb-item active">{{ ucfirst($option_key) }}</li>
	</ol>
  </div>
</div>
@endsection

@section('content')
<div class="row">
	<div class = "col-md-9" >
		<div class="card card-primary">
		  <div class="card-header">
			<h3 class="card-title">{{ ucfirst($option_key) }}</h3>
		  </div>
		  <div class="card-body">
			@include($theme. '.settings.blocks.'. $option_key)
		  </div>
		</div>
	</div>
</div>
{{-- the below lobrary is used for the date time picker--}}
<style type="text/css">
  .bold{ cursor: pointer;
    color: #555;
    display: block;
    padding: 10px;
    margin: 3px;
    font-size: 14px;
  }
  #col_logoImgArea .row{border: 2px #575656 solid; padding: 9px 1px 7px 0px;margin-bottom: 3px;}
</style>   

<style type="text/css">
  .TFtable{width:98%; border-collapse:collapse; } .TFtable td{border:#4e95f4 1px solid; } /* provide some minimal visual accomodation for IE8 and below */ .TFtable tr{background: #b8d1f3; } /*  Define the background color for all the ODD background rows  */ .TFtable tr:nth-child(odd){background: #b8d1f3; } /*  Define the background color for all the EVEN background rows  */ .TFtable tr:nth-child(even){background: #dae5f4; } </style> <style type="text/css"> @import url(https://fonts.googleapis.com/css?family=Open+Sans); * {font-family: 'Open Sans', sans-serif; } .responsive-table {overflow: auto; } table {width: 100%; border-spacing: 0; border-collapse: collapse; white-space:nowrap; } td{border:#4e95f4 1px solid; } /* provide some minimal visual accomodation for IE8 and below */ tr{background: #b8d1f3; } /*  Define the background color for all the ODD background rows  */ tr:nth-child(odd){background: #b8d1f3; } /*  Define the background color for all the EVEN background rows  */ tr:nth-child(even){background: #dae5f4; } img {font-style: italic; font-size: 11px; } .fa-bars{cursor: move; } 
</style>

   


<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/css/bootstrap-tokenfield.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tokenfield/0.12.0/bootstrap-tokenfield.js"></script>




@endsection