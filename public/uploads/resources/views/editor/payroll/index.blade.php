@extends('layouts.editor.template')
@section('module', 'Setting')   
@section('title', 'Payroll')   
@section('required', 'errorEmployeeStatusName')   
@section('content')
 <!-- Page Content -->
<div id="page-wrapper">
  <div class="container-fluid">
      <div class="row bg-title">
          <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
              <h4 class="page-title">@yield('title')</h4>
          </div>
          <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
              <ol class="breadcrumb">
                  <li><a href="{{ url('/editor') }}">Dashboard</a></li>
                  <li><a href="#">@yield('module')</a></li>
                  <li class="active">@yield('title')</li>
              </ol>
          </div>
          <!-- /.col-lg-12 -->
      </div>

      <!-- /row -->
      <div class="row">
          <div class="col-sm-12"> 
              <div class="table-responsive"> 
                <div class="col-sm-12">
                    <div class="white-box"> 
                        <div class="button-box">
                          <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <label class="control-label col-md-1 pull-left">Periode</label>
                                <div class="col-md-4 pull-left">
                                  @if(empty($period))
                                    {{ Form::select('periodid', $payroll_period_list, old('periodid'), array('class' => 'form-control', 'placeholder' => 'Select Period', 'id' => 'periodid', 'onchange' => 'CraeteData();')) }}  
                                  @else
                                    {{ Form::select('periodid', $payroll_period_list, old('periodid', $period), array('class' => 'form-control', 'placeholder' => 'Select Period', 'id' => 'periodid', 'onchange' => 'CraeteData();')) }}  
                                  @endif
                              </div>
                              <div class="col-lg-4 pull-left">
                                <a onClick="GenerateData();" class="btn btn-danger"> <i class="fa fa-magic"></i>  Refresh<sup><span class="label label-warning">!</span></a> 
                              </sup>
                            </div>
                          </div>
                        </div>
                        <hr>
                        <div class="table-responsive">
                            <table id="dtTable" class="display nowrap" cellspacing="0" width="100%">
                                <thead>
                                    <tr>
                                        <th>Action</th> 
                                        <th>Description</th> 
                                        <th>Period</th> 
                                        <th>Start Date</th> 
                                        <th>End Date</th>
                                        <th>Payment Date</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Payroll Type</th> 
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
      </div>
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
     fixedColumns:   {
      leftColumns: 4 
     },
     dom: 'Bfrtip',
     buttons: [
          'copy', 'csv', 'excel', 'pdf', 'print'
     ], 
     ajax: "{{ url('editor/payroll/data') }}",
     columns: [   
     { data: 'action', name: 'action', orderable: false, searchable: false }, 
     { data: 'description', name: 'description' },
     { data: 'date_period', name: 'date_period', render: function(d){return moment(d).format("DD-MM-YYYY");} },
     { data: 'begin_date', name: 'begin_date', render: function(d){return moment(d).format("DD-MM-YYYY");} },
     { data: 'end_date', name: 'end_date', render: function(d){return moment(d).format("DD-MM-YYYY");} },
     { data: 'pay_date', name: 'pay_date', render: function(d){return moment(d).format("DD-MM-YYYY");} }, 
     { data: 'month', name: 'month' },
     { data: 'year', name: 'year' },
     { data: 'payroll_type_name', name: 'payroll_type_name' }, 
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

  function CraeteData()
  {
    var periodid = $('#periodid').val();
    var perioddesc = $("#periodid option:selected").text();
     waitingDialog.show('Process...', {dialogSize: 'sm', progressType: 'warning'});
     $.ajax({
      url : 'payroll/create/' + periodid,
      type: "POST",
      data: {
        '_token': $('input[name=_token]').val() 
      },
      success: function(data)
      { 
        var options = { 
          "positionClass": "toast-bottom-right", 
          "timeOut": 1000, 
        };
        waitingDialog.hide();
        toastr.success('Successfully created data!', 'Success Alert', options);
        reload_table();
      },
      error: function (jqXHR, textStatus, errorThrown)
      {
        $.alert({
          type: 'red',
          icon: 'fa fa-danger', // glyphicon glyphicon-heart
          title: 'Warning',
          content: 'Error creating data!',
        });
      }
    });
 }
      
  function GenerateData()
  {
    var periodid = $('#periodid').val();
    var perioddesc = $("#periodid option:selected").text();

    if(periodid == ''){
      $.alert({
      type: 'red',
      icon: 'fa fa-danger', // glyphicon glyphicon-heart
      title: 'Warning',
      content: 'Period can not be null!',
    });
    }else{
      $.confirm({
        title: 'Confirm!',
        content: 'Are you sure to generate <b><u>' + perioddesc + '</u></b> data?',
        type: 'red',
        typeAnimated: true,
        buttons: {
        cancel: {
         action: function () { 
           }
         },
         confirm: {
          text: 'CREATE',
          btnClass: 'btn-red',
          action: function () { 
          waitingDialog.show('Process...', {dialogSize: 'sm', progressType: 'warning'});
           $.ajax({
            url : 'payroll/generate/' + periodid,
            type: "POST",
            data: {
              '_token': $('input[name=_token]').val() 
            },
            success: function(data)
            { 
              var options = { 
                "positionClass": "toast-bottom-right", 
                "timeOut": 1000, 
              };
              waitingDialog.hide();
              toastr.success('Successfully genareted data!', 'Success Alert', options);
              reload_table();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
              $.alert({
                type: 'red',
                icon: 'fa fa-danger', // glyphicon glyphicon-heart
                title: 'Warning',
                content: 'Error generate data!',
              });
              waitingDialog.hide();
            }
          });
         }
       },
     }
   });
  }
  }
  function RefreshData()
   {  
    $.ajax({
      type: 'POST',
      url: "{{ URL::route('editor.periodfilteronly') }}",
      data: {
        '_token': $('input[name=_token]').val(),     
        'periodid': $('#periodid').val()   
      }, 
      success: function(data) { 
        var options = { 
          "positionClass": "toast-bottom-right", 
          "timeOut": 1000, 
        };
        toastr.success('Successfully filtering data!', 'Success Alert', options);
        reload_table();
      }
    }) 
  }; 
  $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();   
  });

  /**
   * Module for displaying "Waiting for..." dialog using Bootstrap
   *
   * @author Eugene Maslovich <ehpc@em42.ru>
   */

    var waitingDialog = waitingDialog || (function ($) {
        'use strict';

      // Creating modal dialog's DOM
      var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
          '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
          '<div class="modal-body">' +
            '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
          '</div>' +
        '</div></div></div>');

      return {
        /**
         * Opens our dialog
         * @param message Process...
         * @param options Custom options:
         *          options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
         *          options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
         */
        show: function (message, options) {
          // Assigning defaults
          if (typeof options === 'undefined') {
            options = {};
          }
          if (typeof message === 'undefined') {
            message = 'Loading';
          }
          var settings = $.extend({
            dialogSize: 'm',
            progressType: '',
            onHide: null // This callback runs after the dialog was hidden
          }, options);

          // Configuring dialog
          $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
          $dialog.find('.progress-bar').attr('class', 'progress-bar');
          if (settings.progressType) {
            $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
          }
          $dialog.find('h3').text(message);
          // Adding callbacks
          if (typeof settings.onHide === 'function') {
            $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
              settings.onHide.call($dialog);
            });
          }
          // Opening dialog
          $dialog.modal();
        },
        /**
         * Closes dialog
         */
        hide: function () {
          $dialog.modal('hide');
        }
      };

    })(jQuery);
 </script> 
 @stop