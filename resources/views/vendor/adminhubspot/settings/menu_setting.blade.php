{{-- extending the layout --}}
@extends($theme. '.layouts.adminapp')

@section('breadcamp')
  <div class="row mb-2">
    <div class="col-sm-6">
	  <h1>Site Top Menu</h1>
    </div>
    <div class="col-sm-6">
	  <ol class="breadcrumb float-sm-right">
	    <li class="breadcrumb-item"><a href="#">Home</a></li>
	    <li class="breadcrumb-item active">Site Top Menu</li>
	  </ol>
    </div>
  </div>
@endsection

@section('stylesheets')


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
<link href="{{ asset('/plugins/nestable/style.css') }}" rel="stylesheet">
@endsection

@section('scripts')
<script src="{{ asset('/plugins/nestable/jquery.nestable.js') }}"></script>
<script src="{{ asset('/plugins/nestable/jquery.nestablepp.js') }}"></script>

<script>
      $('.dd.nestable').nestable({
        maxDepth: 5
      })
        .on('change', updateOutput);
    </script>
@endsection

@section('content')
<div class="card">
<div class="card-body">
      <div class="row">
        <div class="col-md-6">
          <h3>Menu</h3>
          <div class="dd nestable">
            <ol class="dd-list">

              <!--- Initial Menu Items --->

              <!--- Item1 --->
              <li class="dd-item" data-id="1" data-name="Item 1" data-slug="item-slug-1" data-new="0" data-deleted="0">
                <div class="dd-handle">Item 1</div>
                <span class="button-delete btn btn-default btn-xs pull-right"
                      data-owner-id="1">
                  <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                </span>
                <span class="button-edit btn btn-default btn-xs pull-right"
                      data-owner-id="1">
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </span>
              </li>

              <!--- Item3 --->
              <li class="dd-item" data-id="3" data-name="Item 3" data-slug="item-slug-3" data-new="0" data-deleted="0">
                <div class="dd-handle">Item 3</div>
                <span class="button-delete btn btn-default btn-xs pull-right"
                      data-owner-id="3">
                  <i class="fa fa-times-circle-o" aria-hidden="true"></i>
                </span>
                <span class="button-edit btn btn-default btn-xs pull-right"
                      data-owner-id="3">
                  <i class="fa fa-pencil" aria-hidden="true"></i>
                </span>
              </li>

              <!--------------------------->

            </ol>
          </div>
        </div>
        <div class="col-md-6">
          <form class="form-inline" id="menu-add">
            <h3>New Menu</h3>
            <div class="form-group">
              <label for="addInputName">Name</label>
              <input type="text" class="form-control" id="addInputName" placeholder="Item name" required>
            </div>
            <div class="form-group">
              <label for="addInputSlug">Slug</label>
              <input type="text" class="form-control" id="addInputSlug" placeholder="item-slug" required>
            </div>
            <button class="btn btn-info" id="addButton">Add</button>
          </form>

          <form class="" id="menu-editor" style="display: none;">
            <h3>Editing <span id="currentEditName"></span></h3>
            <div class="form-group">
              <label for="addInputName">Name</label>
              <input type="text" class="form-control" id="editInputName" placeholder="Item name" required>
            </div>
            <div class="form-group">
              <label for="addInputSlug">Slug</label>
              <input type="text" class="form-control" id="editInputSlug" placeholder="item-slug">
            </div>
            <button class="btn btn-info" id="editButton">Edit</button>
          </form>
        </div>
      </div>

      <div class="row output-container">
        <div class="col-md-offset-1 col-md-10">
          <h2 class="text-center">Output:</h2>
          <form class="form">
            <textarea class="form-control" id="json-output" rows="5"></textarea>
          </form>
        </div>
      </div>

    </div>
</div>
@endsection