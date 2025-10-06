<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar" style="min-height: 100px;border: 1px solid rgba(0,0,0,0)">
    <!-- Sidebar user panel -->
     <!--  <div class="user-panel">
        <div class="pull-left image">
          @if(Auth::user()->filename == null)
            <img src="{{Config::get('constants.path.img')}}/avatar5.png" class="img-circle" alt="User Image">
          @else
            <img src="{{Config::get('constants.path.uploads')}}/user/{{Auth::user()->username}}/thumbnail/{{Auth::user()->filename}}" class="img-circle" alt="User Image">
          @endif
        </div>
        <div class="pull-left info">
          <p>{{Auth::user()->username}}</p>
          <a href="#"> {{Auth::user()->first_name}} {{Auth::user()->last_name}}</a>
        </div>
      </div> -->
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" style="margin-top:45px">
        <li class="header">MAIN NAVIGATION</li>
        <li class="treeview">
          <a href="{{url('/')}}/editor">
            <i class="fa fa-home yellow-sumobo"></i> 
            <span>Home</span>
          </a>
        </li>
        <li class="treeview">

          <a href="#">
            <i class="fa fa-money yellow-sumobo"></i>
            <span>Revenue</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          @actionStart('revenue', 'read')
          <ul class="treeview-menu">
            <li><a href="{{ URL::route('editor.revenue.index') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Outstanding</a></li>
            <li><a href="{{ URL::route('editor.revenue.bank') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Bank</a></li>
          </ul> 
          @actionEnd
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dollar yellow-sumobo"></i>
            <span>Cashbond</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            @actionStart('cashbond', 'read')
            <li><a href="{{ URL::route('editor.cashbond.index') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Outstanding</a></li> 
            @actionEnd 
            @actionStart('cashbondbank', 'read')
            <li><a href="{{ URL::route('editor.cashbondbank.index') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Bank</a></li>
            @actionEnd  
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-file-text-o yellow-sumobo"></i>
            <span>Invoice</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu"> 
            @actionStart('invoice', 'read')
            <li><a href="{{ URL::route('editor.invoice.index') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Utilization</a></li>
            @actionEnd
            @actionStart('invoicedirect', 'read')
            <li><a href="{{ URL::route('editor.invoicedirect.index') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Consumable</a></li>
            @actionEnd
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-dot-circle-o yellow-sumobo"></i>
            <span>Central</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>

          <ul class="treeview-menu">
            @actionStart('item_central', 'read')
            <li><a href="{{ URL::route('editor.item_central.index') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Outstanding</a></li>
            @actionEnd
            @actionStart('item_central_bank', 'read')
            <li><a href="{{ URL::route('editor.item_central_bank.index') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Bank</a></li>
            @actionEnd
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-database yellow-sumobo"></i>
            <span>Payroll</span>
            @if(isset($global_pending_cashbond_payroll) || isset($global_pending_payroll))
            <i class="fa fa-warning"></i>
            @endif
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
           @actionStart('cashbond_payroll', 'read')
           <li>
            <a href="{{URL::route('editor.cashbond_payroll.index')}}"><i class="fa fa-dollar yellow-sumobo"></i>&nbsp;&nbsp;Cashbond
              @if(isset($global_pending_cashbond_payroll))
                @actionStart('cashbond_payroll', 'read')
                <i class="fa fa-warning"></i>
                @actionEnd
              @elseif(isset($global_finance_cashbond_payroll))
                @actionStart('cashbond_payroll', 'paid')
                <i class="fa fa-warning"></i>
                @actionEnd
              @elseif(isset($global_owner_cashbond_payroll))
                @actionStart('cashbond_payroll', 'issued')
                <i class="fa fa-warning"></i>
                @actionEnd
              @endif
            </a>
          </li>
          @actionEnd
          @actionStart('payroll', 'read')
          {{-- <li><a href="#"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Monthly Payroll</a></li> --}}
          <li>
            <a href="{{ URL::route('editor.payroll.index') }}"><i class="fa fa-list-ul yellow-sumobo"></i>&nbsp;&nbsp;Payroll List
              @if(isset($global_pending_payroll))
                @actionStart('payroll', 'read')
                <i class="fa fa-warning"></i>
                @actionEnd
              @elseif(isset($global_finance_payroll))
                @actionStart('payroll', 'paid')
                <i class="fa fa-warning"></i>
                @actionEnd
              @elseif(isset($global_owner_payroll))
                @actionStart('payroll', 'issued')
                <i class="fa fa-warning"></i>
                @actionEnd
              @endif
            </a>
          </li>
          @actionEnd
        </ul>
      </li>
      @actionStart('franchise_fee', 'read')
      <li class="treeview">
        <a href="{{ URL::route('editor.franchise_fee.index') }}">
          <i class="fa fa-industry yellow-sumobo"></i> 
          <span>Franchise Fee</span>
          @if(isset($global_pending_franchise_fee))
            @actionStart('franchise_fee', 'read')
            <i class="fa fa-warning"></i>
            @actionEnd
          @elseif(isset($global_finance_franchise_fee))
            @actionStart('franchise_fee', 'paid')
            <i class="fa fa-warning"></i>
            @actionEnd
          @elseif(isset($global_owner_franchise_fee))
            @actionStart('franchise_fee', 'issued')
            <i class="fa fa-warning"></i>
            @actionEnd
          @endif
        </a>
      </li>
      @actionEnd
      @actionStart('employee', 'read')
      <li class="treeview">
        <a href="{{ URL::route('editor.employee.index') }}">
          <i class="fa fa-users yellow-sumobo"></i> 
          <span>Employee List</span>
        </a>
      </li>
      @actionEnd

      @actionStart('item_type', 'read', 'item_category', 'read', 'item', 'read', 'invoice_type', 'read', 'vendor', 'read', 'item', 'read', 'item', 'read', 'item_category', 'read')
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user yellow-sumobo"></i>
          <span>Admin</span>

          <i class="fa fa-angle-left pull-right"></i>
        </span>
      </a>
      <ul class="treeview-menu">
       @actionStart('user', 'read')
       <li><a href="{{ URL::route('editor.user.index') }}"><i class="fa fa-user-circle yellow-sumobo"></i>&nbsp;&nbsp;User List</a></li>
       @actionEnd

       @actionStart('module', 'read')
       <li><a href="{{ URL::route('editor.module.index') }}"><i class="fa fa-cog yellow-sumobo"></i>&nbsp;&nbsp;Module List</a></li>
       @actionEnd

       @actionStart('action', 'read')
       <li><a href="{{ URL::route('editor.action.index') }}"><i class="fa fa-wrench yellow-sumobo"></i>&nbsp;&nbsp;Action List</a></li>
       @actionEnd

       @actionStart('privilege', 'read')
       <li><a href="{{ URL::route('editor.privilege.index') }}"><i class="fa fa-vcard yellow-sumobo"></i>&nbsp;&nbsp;Privilege List</a></li>
       @actionEnd

       @actionStart('branch', 'read')
       <li><a href="{{ URL::route('editor.branch.index') }}"><i class="fa fa-building yellow-sumobo"></i>&nbsp;&nbsp;Branch</a></li>
       @actionEnd

       @actionStart('item_type', 'read', 'item_category', 'read', 'item', 'read')
       <li>
        <a href="#">
          <i class="fa fa-dollar yellow-sumobo"></i>
          <span>Cashbond</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
         @actionStart('item_type', 'read')
         <li><a href="{{ URL::route('editor.item_type.index') }}"><i class="fa fa-cubes yellow-sumobo"></i>&nbsp;&nbsp;Type</a></li>
         @actionEnd
         @actionStart('item_category', 'read')
         <li><a href="{{ URL::route('editor.item_category.index') }}"><i class="fa fa-cubes yellow-sumobo"></i>&nbsp;&nbsp;Category</a></li>
         @actionEnd
         @actionStart('item', 'read')
         <li><a href="{{ URL::route('editor.item.index',[2]) }}"><i class="fa fa-cube yellow-sumobo"></i>&nbsp;&nbsp;Item</a></li>
         @actionEnd
       </ul>
     </li>
     @actionEnd

     @actionStart('invoice_type', 'read', 'vendor', 'read', 'item', 'read')
     <li>
      <a href="#">
        <i class="fa fa-file-text-o yellow-sumobo"></i>
        <span>Invoice</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
        @actionStart('invoice_type', 'read')
        <li><a href="{{ URL::route('editor.invoice_type.index') }}"><i class="fa fa-file-archive-o yellow-sumobo"></i>&nbsp;&nbsp;Category</a></li>
        @actionEnd
        @actionStart('vendor', 'read')
        <li><a href="{{ URL::route('editor.vendor.index') }}"><i class="fa fa-handshake-o yellow-sumobo"></i>&nbsp;&nbsp;Vendor</a></li> 
        @actionEnd
        @actionStart('vendoritem', 'read')
        <li><a href="{{ URL::route('editor.vendoritem.index') }}"><i class="fa fa-handshake-o yellow-sumobo"></i>&nbsp;&nbsp;Vendor Item</a></li> 
        @actionEnd
        @actionStart('item', 'read')
        <li><a href="{{ URL::route('editor.item.index', [3]) }}"><i class="fa fa-cube yellow-sumobo"></i>&nbsp;&nbsp;Item</a></li>
        @actionEnd
      </ul>
    </li>
    @actionEnd

    @actionStart('item', 'read', 'item_category', 'read')
    <li>
      <a href="#">
        <i class="fa fa-dot-circle-o yellow-sumobo"></i>
        <span>Central</span>
        <i class="fa fa-angle-left pull-right"></i>
      </a>
      <ul class="treeview-menu">
       @actionStart('item', 'read')
       <li><a href="{{ URL::route('editor.item.index', [1]) }}"><i class="fa fa-cube yellow-sumobo"></i>&nbsp;&nbsp;Item</a></li>
       @actionEnd
       @actionStart('item_category', 'read')
       <li><a href="{{ URL::route('editor.item_category.index') }}"><i class="fa fa-cubes yellow-sumobo"></i>&nbsp;&nbsp;Item Central Category</a></li>  
       @actionEnd
     </ul>
   </li>
   @actionEnd
 </ul>
</li>  
@actionEnd 
</section>
<!-- /.sidebar -->
</aside>