@extends('layouts.editor.template')
@section('content')
<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header" style="margin-top:-15px !important; margin-bottom:-20px !important">
  <h4>
    City
  </h4>
  <ol class="breadcrumb">
    <li><a href="index.php"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Master Data</a></li>
    <li class="active">City</li>
  </ol>
</section>

<section class="content">
  <div class="row">
    <div class="col-xs-12">
      <div class="box box-danger">
        <div class="box-header with-border" style="height:50px !important; margin-top:-2px !important">
          <button onClick="add()" type="button" class="btn btn-primary btn-flat"> <i class="fa fa-sticky-note-o"></i> Add New</button>
          <button onClick="history.back()" type="button" class="btn btn-primary btn-flat"> <i class="fa fa-undo"></i> Back</button>
          <button onClick="reload_table()" type="button" class="btn btn-success btn-flat"> <i class="fa fa-refresh"></i> Refresh</button>
          <button class="btn btn-danger btn-flat" onclick="bulk_delete()"><i class="glyphicon glyphicon-trash"></i> Bulk Delete</button>
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
                  <th style="width:5%">
                    <label class="control control--checkbox">
                      <input type="checkbox" id="check-all"/>
                      <div class="control__indicator"></div>
                    </label>

                  </th>
                  <th>Action</th> 
                  <th>City Name</th> 
                  <th>Status</th>
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
         <h3 class="modal-title">City Form</h3>
       </div>
       <div class="modal-body">
         <input type="hidden" value="" name="idrack"/> 
         <div class="form-body">
          <div class="row">
 
            <div class="form-group">
              <label class="control-label col-md-3">City Name</label>
              <div class="col-md-8">
                <input name="cityname" id="cityname" class="form-control" type="text">
                <small class="errorCityName hidden alert-danger"></small> 
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
</div><!-- /.modal -->
<!-- End Bootstrap modal -->

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
         ajax: "{{ url('editor/city/data') }}",
         columns: [  
         { data: 'check', name: 'check', orderable: false, searchable: false },
         { data: 'action', name: 'action', orderable: false, searchable: false }, 
         { data: 'cityname', name: 'cityname' },
         { data: 'mstatus', name: 'mstatus' }
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

      function add()
      {
        $("#btnSave").attr("onclick","save()");
        $("#btnSaveAdd").attr("onclick","saveadd()");
 
        $('.errorCityName').addClass('hidden');

        save_method = 'add';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#modal_form').modal('show'); // show bootstrap modal
        $('.modal-title').text('Add City'); // Set Title to Bootstrap modal title
      }

      function save()
      {   
        var url;
        url = "{{ URL::route('editor.city.store') }}";
        
        $.ajax({
          type: 'POST',
          url: url,
          data: {
            '_token': $('input[name=_token]').val(), 
            'cityname': $('#cityname').val(), 
            'status': $('#status').val()
          },
          success: function(data) { 
 
            $('.errorCityName').addClass('hidden');

            if ((data.errors)) {
              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              toastr.error('Data is required!', 'Error Validation', options);
              
              if (data.errors.cityname) {
                $('.errorCityName').removeClass('hidden');
                $('.errorCityName').text(data.errors.cityname);
              }
            } else {

              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              toastr.success('Successfully added data!', 'Success Alert', options);
              $('#modal_form').modal('hide');
                    $('#form')[0].reset(); // reset form on modals
                    reload_table(); 
                  } 
                },
              })
      };

      function saveadd()
      {   
       $.ajax({
        type: 'POST',
        url: "{{ URL::route('editor.city.store') }}",
        data: {
          '_token': $('input[name=_token]').val(), 
          'cityname': $('#cityname').val(), 
          'status': $('#status').val()
        },
        success: function(data) {  
            $('.errorCityName').addClass('hidden');

            if ((data.errors)) {
              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              toastr.error('Data is required!', 'Error Validation', options);
            
              if (data.errors.cityname) {
                $('.errorCityName').removeClass('hidden');
                $('.errorCityName').text(data.errors.cityname);
              }
            } else {
          var options = { 
            "positionClass": "toast-bottom-right", 
            "timeOut": 1000, 
          };
          toastr.success('Successfully added data!', 'Success Alert', options);

                    $('#form')[0].reset(); // reset form on modals
                    reload_table(); 
                  } 
                },
              })
     };

     function edit(id)
     { 

      $('.errorCityName').addClass('hidden');

      //alert("asdad");

      $("#btnSave").attr("onclick","update("+id+")");

      $("#btnSaveAdd").attr("onclick","updateadd("+id+")");

      save_method = 'update';
        $('#form')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
          url : 'city/edit/' + id,
          type: "GET",
          dataType: "JSON",
          success: function(data)
          {

            $('[name="id_key"]').val(data.id); 
            $('[name="cityname"]').val(data.cityname);
            $('[name="status"]').val(data.status);
                $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit City'); // Set title to Bootstrap modal title
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
          url: 'city/edit/' + id,
          type: "PUT",
          data: {
            '_token': $('input[name=_token]').val(), 
            'cityname': $('#cityname').val(), 
            'status': $('#status').val()
          },
          success: function(data) {  
            $('.errorCityName').addClass('hidden');

            if ((data.errors)) {
              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              toastr.error('Data is required!', 'Error Validation', options);
             
              if (data.errors.cityname) {
                $('.errorCityName').removeClass('hidden');
                $('.errorCityName').text(data.errors.cityname);
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
      };

      function updateadd(id)
      {
        save_method = 'update'; 
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string

        //Ajax Load data from ajax
        $.ajax({
          url: 'city/edit/' + id,
          type: "PUT",
          data: {
            '_token': $('input[name=_token]').val(), 
            'cityname': $('#cityname').val(), 
            'status': $('#status').val()
          },
          success: function(data) { 
            if ((data.errors)) {
             swal("Error!", "Gat data failed!", "error")
           } else { 
            var options = { 
              "positionClass": "toast-bottom-right", 
              "timeOut": 1000, 
            };
            toastr.success('Successfully updated data!', 'Success Alert', options);
                    $('#form')[0].reset(); // reset form on modals
                    reload_table(); 
                    $("#btnSave").attr("onclick","save()");
                    $("#btnSaveAdd").attr("onclick","saveadd()");
                  } 
                },
              })
      };

      function delete_id(id, cityname)
      {

        //var varnamre= $('#cityname').val();
        var cityname = cityname.bold();

        $.confirm({
          title: 'Confirm!',
          content: 'Are you sure to delete ' + cityname + ' data?',
          type: 'red',
          typeAnimated: true,
          buttons: {
            cancel: {
             action: function () { 
             }
           },
           confirm: {
            text: 'DELETE',
            btnClass: 'btn-red',
            action: function () {
             $.ajax({
              url : 'city/delete/' + id,
              type: "DELETE",
              data: {
                '_token': $('input[name=_token]').val() 
              },
              success: function(data)
              { 
                var options = { 
                  "positionClass": "toast-bottom-right", 
                  "timeOut": 1000, 
                };
                toastr.success('Successfully deleted data!', 'Success Alert', options);
                reload_table();
              },
              error: function (jqXHR, textStatus, errorThrown)
              {
                $.alert({
                  type: 'red',
                        icon: 'fa fa-danger', // glyphicon glyphicon-heart
                        title: 'Warning',
                        content: 'Error deleteing data!',
                      });
              }
            });
           }
         },

       }
     });
      }

      function bulk_delete()
      {


        var list_id = [];
        $(".data-check:checked").each(function() {
          list_id.push(this.value);
        });
        if(list_id.length > 0)
        {


          $.confirm({
            title: 'Confirm!',
            content: 'Are you sure to delete '+list_id.length+' data?',
            type: 'red',
            typeAnimated: true,
            buttons: {
              cancel: {
               action: function () {

               }
             },
             confirm: {
              text: 'DELETE',
              btnClass: 'btn-red',
              action: function () {
               $.ajax({
                 data: {
                  '_token': $('input[name=_token]').val(),
                  'idkey': list_id,
                }, 
                url: "city/deletebulk",
                type: "POST", 
                dataType: "JSON",
                success: function(data)
                {
                  if(data.status)
                  {


                    reload_table();
                  }
                  else
                  {
                    alert('Failed.');
                  }

                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                  $.alert({
                    type: 'red',
                                icon: 'fa fa-danger', // glyphicon glyphicon-heart
                                title: 'Warning',
                                content: 'Error deleting data!',
                              });
                }
              });
             }
           },

         }
       });
        }
        else
        {
         $.alert({
          type: 'orange',
                icon: 'fa fa-warning', // glyphicon glyphicon-heart
                title: 'Warning',
                content: 'No data selected!',
              });
       }
     }
   </script> 
   @stop
