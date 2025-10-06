@extends('layouts.editor.template')
@section('content')
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header" style="margin-top: -10px; margin-bottom: -10px">
  <h1>
    <i class="fa fa-cogs"></i> User Filter
    <small>Setting</small>
  </h1>
  <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Setting</a></li>
    <li class="active">User Filter</li>
  </ol>
</section>

<section class="content">
{{ csrf_field() }}
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header with-border" style="height:50px !important; margin-top:-2px !important">
          <button onClick="history.back()" type="button" class="btn btn-primary btn-flat"> <i class="fa fa-undo"></i> Back</button>
          <button onClick="reload_table()" type="button" class="btn btn-success btn-flat"> <i class="fa fa-refresh"></i> Refresh</button>
          <!-- <button class="btn btn-danger btn-flat" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Bulk Delete</button> -->
          <div class="box-tools pull-right">
            <div class="tableTools-container">
            </div>
          </div><!-- /.box-tools -->
        </div>
        <div class="box-header">
          <!-- /.panel-heading -->
          <div class="box-body">
            <table id="dtTable" class="table table-bordered table-hover stripe">
              <thead>
                <tr>
                  <th>Action</th> 
                  <th>Username</th>
                  <th>GR From</th>
                  <th>GR To</th> 
                  <th>Item Category</th>
                  <th>Container</th>
                  <th>Search</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>  


<!-- Bootstrap modal -->
<div class="modal fade" id="modal_form" role="dialog">
  <div class="modal-dialog" style="width:40% !important">
    <div class="modal-content">
      <form action="#" id="form" class="form-horizontal">
        {{ csrf_field() }}
        <div class="modal-header" style="height: 60px">
          <div class="form-group pull-right">
            <label for="real_name" class="col-sm-4 control-label">Status</label>
            <div class="col-sm-8 pull-right">
              <select class="form-control" style="width: 100%;" name="status"  id="status">
               <option value="0">Active</option>
               <option value="1">Not Active</option>
             </select>
           </div>
         </div>
         <h3 class="modal-title">User Filter Form</h3>
       </div>
       <div class="modal-body">
         <input type="hidden" value="" name="idrack"/> 
         <div class="form-body">
          <div class="row">
            <div class="form-group">
              <label class="control-label col-md-3">Username</label>
              <div class="col-md-8">
                <input name="username" id="username" class="form-control" type="text" readonly>
              </div>
            </div> 
            <div class="form-group">
              <label class="control-label col-md-3">GR From</label>
              <div class="col-md-8">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                    <input name="grfrom" id="grfrom" class="form-control" type="text">
                </div>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-3">GR To</label>
              <div class="col-md-8">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-calendar"></i></span> 
                    <input name="grto" id="grto" class="form-control" type="text">
                </div>
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-md-3">Item Category</label>
              <div class="col-md-8">
                <select class="form-control" style="width: 100%;" name="item_category_id"  id="item_category_id">
                 @foreach($item_category as $item_categorys)
                  <option value="{{$item_categorys->id}}">{{$item_categorys->item_category_name}}</option>
                 @endforeach
               </select>
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-md-3">Container</label>
              <div class="col-md-8">
                <select class="form-control" style="width: 100%;" name="container_id"  id="container_id">
                 @foreach($container as $containers)
                  <option value="{{$containers->id}}">{{$containers->container_name}}</option>
                 @endforeach
               </select>
              </div>
            </div>
             <div class="form-group">
              <label class="control-label col-md-3">Search</label>
              <div class="col-md-8">
                <div class="input-group">
                  <span class="input-group-addon"><i class="fa fa-search"></i></span> 
                    <input name="search" id="search" class="form-control" type="text">
                </div>
              </div>
            </div>
 
        </div>
      </div>
    </form>
    <div class="modal-footer">
      <button type="button" class="btn btn-default btn-flat pull-left" data-dismiss="modal"><i class="fa fa-close"></i> Close</button>
      <button type="button" id="btnSaveAdd" onClick="saveadd()" class="btn btn-primary btn-flat pull-right" style="margin-left:5px !important">  <i class="fa fa-plus-square"></i> Save & Add</button>
      <button type="button" id="btnSave"  class="btn btn-primary btn-flat pull-right" style="margin-left:5px !important">  <i class="fa fa-save"></i> Save & Close</button>

    </div>
  </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
</div>
</div>
 
@stop
@section('scripts')
<script>
  var table;
  $(document).ready(function() {
        //datatables
        table = $('#dtTable').DataTable({ 
         processing: true,
         serverSide: true,
         "pageLength": 25,
         "scrollY": "360px",
         "lengthMenu": [[25, 50, 100, -1], [25, 50, 100, "All"]],
         ajax: "{{ url('editor/userfilter/data') }}",
         columns: [  
         { data: 'action', name: 'action', orderable: false, searchable: false }, 
         { data: 'username', name: 'username' },
         { data: 'grfrom', name: 'grfrom' },
         { data: 'grto', name: 'grto' },
         { data: 'item_category_name', name: 'item_category_name' },
         { data: 'container_no', name: 'container_no' },
         { data: 'search', name: 'search' }
         ]
       });
        //check all
        $("#check-all").click(function () {
          $(".data-check").prop('checked', $(this).prop('checked'));
        });
      });
      function reload_table()
      {
        table.ajax.reload(null,false); //reload datatable ajax 
      }

      
     function edit(id)
     { 

      $('.errorContainerName').addClass('hidden');

      //alert("asdad");

      $("#btnSave").attr("onclick","update("+id+")");

      $("#btnSaveAdd").attr("onclick","updateadd("+id+")");

      save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
          url : 'userfilter/edit/' + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {
            $('[name="id_key"]').val(data.id); 
            $('[name="username"]').val(data.username);
            $('[name="grfrom"]').val(data.grfrom);
            $('[name="grto"]').val(data.grto);
            $('[name="item_category_id"]').val(data.item_category_id);
            $('[name="container_id"]').val(data.container_id);
            $('[name="search"]').val(data.search); 
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Edit User Filter'); // Set title to Bootstrap modal title
          },
          error: function (jqXHR, textStatus, errorThrown)
          {
            alert('Error get data from ajax');
          }
        });
      }

      function update(id)
      {
        save_method = 'update'; 
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
          url: 'userfilter/edit/' + id,
          type: "PUT",
          data: {
            '_token': $('input[name=_token]').val(), 
            'grfrom': $('#grfrom').val(), 
            'grto': $('#grto').val(), 
            'item_category_id': $('#item_category_id').val(), 
            'container_id': $('#container_id').val(), 
            'search': $('#search').val() 
          },
          success: function(data) {  
            $('.errorContainerName').addClass('hidden');

            if ((data.errors)) {
              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              toastr.error('Data is required!', 'Error Validation', options);
             
              if (data.errors.containername) {
                $('.errorContainerName').removeClass('hidden');
                $('.errorContainerName').text(data.errors.containername);
              }
            } else {
            var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.success('Successfully updated data!', 'Success Alert', options);
            $('#modal_form').modal('hide');
                $('#form')[0].reset(); // reset form on modals
                reload_table(); 
              } 
            },
          })
          $('#modal_form').modal('hide');
          $('#form')[0].reset(); // reset form on modals
          reload_table(); 
      };
   </script> 

   <!-- Add fancyBox -->
   <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />
   <script type="text/javascript" src="{{Config::get('constants.path.plugin')}}/fancybox/jquery.fancybox.pack.js?v=2.1.5"></script>
   <script type="text/javascript">
    $(document).ready(function() {
      $(".fancybox").fancybox();
    });
  </script>
  @stop
