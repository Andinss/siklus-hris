<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <link rel="icon" href="{{Config::get('constants.path.img')}}/favicon.png" type="image/gif" sizes="16x16">
  <title>LMU E-Modal</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- dataTables -->
  <!-- <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/datatables/dataTables.bootstrap.css" /> -->
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/datatables/extensions/datatables.min.css" />
  
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="{{Config::get('constants.path.bootstrap')}}/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css"> -->
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/font-awesome-4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://adminlte.io/themes/AdminLTE/bower_components/select2/dist/css/select2.min.css"> 
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{Config::get('constants.path.css')}}/ionicons.min.css">
  <!-- Checkbox -->
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/checkbox/checkbox.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{Config::get('constants.path.scss')}}/AdminLTE.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
  folder instead of downloading all of them to reduce the load. -->
  <!-- <link rel="stylesheet" href="{{Config::get('constants.path.css')}}/skins/_all-skins.min.css"> -->
  <!-- iCheck -->
  <!-- <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/iCheck/flat/blue.css"> -->
  <!-- Morris chart -->
  <!-- <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/morris/morris.css"> -->
  <!-- jvectormap -->
  <!-- <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/jvectormap/jquery-jvectormap-1.2.2.css"> -->


  <!-- bootstrap wysihtml5 - text editor -->
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/jQueryConfirm/jquery-confirm.min.css">
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/jQueryConfirm/jquery-confirm.min.css">
   
  <!-- fixed coloumn -->
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/datatables/fixedColumns.datatables.min.css">
  
  <!-- toastr notifications -->
  <link rel="stylesheet" href="{{Config::get('constants.path.css')}}/toastr.min.css">
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/daterangepicker/daterangepicker.css">
  <!-- Date Picker -->
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/datepicker/datepicker3.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/daterangepicker/daterangepicker.css">
  <!-- Datetime Picker -->
  <link rel="stylesheet" href="{{Config::get('constants.path.plugin')}}/datetimepicker/bootstrap-datetimepicker.css">

  <!-- jQuery 2.2.3 -->
  <script src="{{Config::get('constants.path.plugin')}}/jQuery/jquery-2.2.3.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="{{Config::get('constants.path.plugin')}}/jQueryUI/jquery-ui.min.js"></script>
   


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
  <script type="text/javascript">
    // insert commas as thousands separators 
    function addCommas(n){
      var rx=  /(\d+)(\d{3})/;
      return String(n).replace(/^\d+/, function(w){
        while(rx.test(w)){
          w= w.replace(rx, '$1,$2');
        }
        return w;
      });
    }
// return integers and decimal numbers from input
// optionally truncates decimals- does not 'round' input
function validDigits(n, dec){
  n= n.replace(/[^\d\.]+/g, '');
  var ax1= n.indexOf('.'), ax2= -1;
  if(ax1!= -1){
    ++ax1;
    ax2= n.indexOf('.', ax1);
    if(ax2> ax1) n= n.substring(0, ax2);
    if(typeof dec=== 'number') n= n.substring(0, ax1+dec);
  }
  return n;
}
</script>
<style>
    .dropdown-submenu {
      position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
      top: 0;
      left: 100%;
      margin-top: -6px;
      margin-left: -1px;
      -webkit-border-radius: 0 6px 6px 6px;
      -moz-border-radius: 0 6px 6px;
      border-radius: 0 6px 6px 6px;
    }

    .dropdown-submenu:hover>.dropdown-menu {
      display: block;
    }

    .dropdown-submenu>a:after {
      display: block;
      content: " ";
      float: right;
      width: 0;
      height: 0;
      border-color: transparent;
      border-style: solid;
      border-width: 5px 0 5px 5px;
      border-left-color: #ccc;
      margin-top: 5px;
      margin-right: -10px;
    }

    .dropdown-submenu:hover>a:after {
      border-left-color: #fff;
    }

    body {
      -webkit-font-smoothing: antialiased;
      -moz-osx-font-smoothing: grayscale;
      font-family: 'Source Sans Pro', 'Helvetica Neue', Helvetica, Arial, sans-serif;
      font-weight: 400;
      overflow-x: hidden;
      overflow-y: auto;
      font-size: 14px 
    }

    .content-headerFixed
    {
      position:fixed;
      background-color: #ecf0f5;
      margin-left:230px;
      left:0;
      right:0;
      padding: 15px 15px 0 15px;
    }
  
  .content-wrapper {
    min-height: 738px;
  }
</style>

</head>
<body class="hold-transition skin-blue fixed layout-top-nav" data-spy="scroll" data-target="#scrollspy">

<!-- <div class="wrapper">  -->

    @include('layouts.editor.header') 
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      @yield('content')
    </div>
    <!-- /.content-wrapper -->

    @include('layouts.editor.footer')

  </div>
  <!-- ./wrapper -->

  @yield('modal')


  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button);
  </script>
  @yield('scripts')
  <!-- Bootstrap 3.3.6 -->
  <script src="{{Config::get('constants.path.bootstrap')}}/js/bootstrap.min.js"></script>
  <!-- Morris.js charts -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script> -->
  <!-- <script src="{{Config::get('constants.path.plugin')}}/morris/morris.min.js"></script> -->
  <!-- Sparkline -->
  <script src="{{Config::get('constants.path.plugin')}}/sparkline/jquery.sparkline.min.js"></script>
  <!-- jvectormap -->
  <script src="{{Config::get('constants.path.plugin')}}/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
  <script src="{{Config::get('constants.path.plugin')}}/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
  <!-- jQuery Knob Chart -->
  <!-- <script src="{{Config::get('constants.path.plugin')}}/knob/jquery.knob.js"></script> -->
  <!-- daterangepicker -->
  <script src="{{Config::get('constants.path.js')}}/moment.min.js"></script>
  <script src="{{Config::get('constants.path.plugin')}}/daterangepicker/daterangepicker.js"></script>
  <!-- datepicker -->
  <script src="{{Config::get('constants.path.plugin')}}/datepicker/bootstrap-datepicker.js"></script>
  <!-- datetimepicker -->
  <script src="{{Config::get('constants.path.plugin')}}/datetimepicker/bootstrap-datetimepicker.min.js"></script>

  
  <!-- Slimscroll -->
  <script src="{{Config::get('constants.path.plugin')}}/slimScroll/jquery.slimscroll.min.js"></script>
  <!-- FastClick -->
  <script src="{{Config::get('constants.path.plugin')}}/fastclick/fastclick.js"></script>
  <!-- AdminLTE App -->
  <script src="{{Config::get('constants.path.js')}}/app.min.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <!-- <script src="{{Config::get('constants.path.js')}}/pages/dashboard.js"></script> -->
  <script src="{{Config::get('constants.path.js')}}/dataTables.fixedColumns.min.js"></script>
 
  <!-- AdminLTE for demo purposes -->
  <script src="{{Config::get('constants.path.js')}}/demo.js"></script>
  <script src="{{Config::get('constants.path.plugin')}}/datatables/extensions/datatables.min.js"></script>
  <!-- <script src="{{Config::get('constants.path.plugin')}}/datatables/jquery.datatables.min.js"></script>  -->
  <script src="{{Config::get('constants.path.plugin')}}/datatables/dataTables.bootstrap.min.js"></script>
  <script src="{{Config::get('constants.path.plugin')}}/datatables/dataTables.tableTools.min.js"></script>
  <script src="{{Config::get('constants.path.plugin')}}/datatables/dataTables.colVis.min.js"></script> 
  <script src="{{Config::get('constants.path.plugin')}}/select2/select2.full.min.js"></script> 

  <script src="{{Config::get('constants.path.plugin')}}/jQueryConfirm/jquery-confirm.min.js"></script>

  <script type="text/javascript" src="{{Config::get('constants.path.js')}}/toastr.min.js"></script>
  <script src="{{Config::get('constants.path.plugin')}}/handlebars/handlebars-v4.0.5.js"></script> 
  
  <!-- Bootstrap WYSIHTML5 -->
  <script src="{{Config::get('constants.path.plugin')}}/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
  <script src="https://adminlte.io/themes/AdminLTE/bower_components/ckeditor/ckeditor.js"></script>

  <script>
    $(function () {
      // Replace the <textarea id="editor1"> with a CKEditor
      // instance, using default configuration.
      CKEDITOR.replace('editor1')
      //bootstrap WYSIHTML5 - text editor
      $('.textarea').wysihtml5()
    })
  </script>

<script type="text/javascript"> 
   $(document).ready(function(){
    $('#grfrom').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });
    $('#grto').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });
    $('#indate').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });
    $('#dateholiday').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#dateperiod').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#begindate').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#enddate').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#paydate').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#idulfitridate').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#paymentdate').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#datefrom').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#dateto').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#datetrans').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });
    $('#date').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });
    $('#trainingfrom').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#trainingto').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#travellingfrom').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
    $('#travellingto').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#leavingfrom').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#leavingto').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    }); 
    $('#effectivedate').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
     $('#startdeduction').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
     $('#tlg_respon').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
     $('#delivery_date').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
    $('#ata').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
    $('#original_doc').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
    $('#pajak_pib').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
    $('#kt2').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
    $('#inspect_kt9').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
    $('#tlg_respon').datepicker({
      sideBySide: true,
      format: 'yyyy-mm-dd',
    });  
  });
</script>

<script type="text/javascript">
  //Initialize Select2 Elements
  $(".select2").select2();

  jQuery(function($) {
      //initiate dataTables plugin
      var oTable1 = 
      $('#dtTable')
      //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)

      //TableTools settings
      TableTools.classes.container = "btn-group btn-overlap";
      TableTools.classes.print = {
        "body": "DTTT_Print",
        "info": "tableTools-alert gritter-item-wrapper gritter-primary gritter-center white",
        "message": "tableTools-print-navbar"
      }

      //initiate TableTools extension
      var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
        "sSwfPath": "{{Config::get('constants.path.swf')}}/copy_csv_xls_pdf.swf",
        
        "sRowSelector": "td:not(:last-child)",
        "sRowSelect": "multi",
        "fnRowSelected": function(row) {
          //check checkbox when row is selected
          try { $(row).find('input[type=checkbox]').get(0).checked = true }
          catch(e) {}
        },
        "fnRowDeselected": function(row) {
          //uncheck checkbox
          try { $(row).find('input[type=checkbox]').get(0).checked = false }
          catch(e) {}
        },

        "sSelectedClass": "success",
        "aButtons": [
        {
          "sExtends": "copy",
          "sToolTip": "Copy to clipboard",
          "sButtonClass": "btn btn-white btn-primary btn-bold",
          "sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
          "fnComplete": function() {
            this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
              <p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
              1500
              );
          }
        },

        {
          "sExtends": "csv",
          "sToolTip": "Export to CSV",
          "sButtonClass": "btn btn-white btn-primary  btn-bold",
          "sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
        },

        {
          "sExtends": "pdf",
          "sToolTip": "Export to PDF",
          "sButtonClass": "btn btn-white btn-primary  btn-bold",
          "sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
        },

        {
          "sExtends": "print",
          "sToolTip": "Print view",
          "sButtonClass": "btn btn-white btn-primary  btn-bold",
          "sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",

          "sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",

          "sInfo": "<h3 class='no-margin-top'>Print view</h3>\
          <p>Please use your browser's print function to\
            print this table.\
            <br />Press <b>escape</b> when finished.</p>",
          }
          ]
        } );
      //we put a container before our table and append TableTools element to it
      $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
      
      //also add tooltips to table tools buttons
      //addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
      //so we add tooltips to the "DIV" child after it becomes inserted
      //flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
      setTimeout(function() {
        $(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
          var div = $(this).find('> div');
          if(div.length > 0) div.tooltip({container: 'body'});
          else $(this).tooltip({container: 'body'});
        });
      }, 200);
      
      //ColVis extension
      var colvis = new $.fn.dataTable.ColVis( oTable1, {
        "buttonText": "<i class='fa fa-search'></i>",
        "aiExclude": [0, 6],
        "bShowAll": true,
        //"bRestore": true,
        "sAlign": "right",
        "fnLabel": function(i, title, th) {
          return $(th).text();//remove icons, etc
        }
        
      }); 
      
      //style it
      $(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-primary btn-bold')
      
      //and append it to our table tools btn-group, also add tooltip
      $(colvis.button())
      .prependTo('.tableTools-container .btn-group')
      .attr('title', 'Show/hide columns').tooltip({container: 'body'});
      
      //and make the list, buttons and checkboxed Ace-like
      $(colvis.dom.collection)
      .addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
      .find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
      .find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');

      /////////////////////////////////
      //table checkboxes
      $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
      
      //select/deselect all rows according to table header checkbox
      $('#dtTable > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $(this).closest('table').find('tbody > tr').each(function(){
          var row = this;
          if(th_checked) tableTools_obj.fnSelect(row);
          else tableTools_obj.fnDeselect(row);
        });
      });
      
      //select/deselect a row when the checkbox is checked/unchecked
      $('#dtTable').on('click', 'td input[type=checkbox]' , function(){
        var row = $(this).closest('tr').get(0);
        if(!this.checked) tableTools_obj.fnSelect(row);
        else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
      });
      
      $(document).on('click', '#dtTable .dropdown-toggle', function(e) {
        e.stopImmediatePropagation();
        e.stopPropagation();
        e.preventDefault();
      });
      
      
      //And for the first simple table, which doesn't have TableTools or dataTables
      //select/deselect all rows according to table header checkbox
      var active_class = 'active';
      $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
        var th_checked = this.checked;//checkbox inside "TH" table header
        
        $(this).closest('table').find('tbody > tr').each(function(){
          var row = this;
          if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
          else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
        });
      });
      
      //select/deselect a row when the checkbox is checked/unchecked
      $('#simple-table').on('click', 'td input[type=checkbox]' , function(){
        var $row = $(this).closest('tr');
        if(this.checked) $row.addClass(active_class);
        else $row.removeClass(active_class);
      });

      /********************************/
      //add tooltip for small view action buttons in dropdown menu
      $('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
      
      //tooltip placement on right or left
      function tooltip_placement(context, source) {
        var $source = $(source);
        var $parent = $source.closest('table')
        var off1 = $parent.offset();
        var w1 = $parent.width();

        var off2 = $source.offset();
        //var w2 = $source.width();

        if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
        return 'left';
      }

    })

</script> 

</body>
</html>
