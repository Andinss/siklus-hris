@extends('layouts.editor.master')
@section('title')
  Aktifitas Pengguna
@stop

@section('content')
<!-- Content Header (Page header) -->


<div id="page-wrapper">
    <div class="container-fluid">
			  <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Aktifitas Pengguna</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                  <ol class="breadcrumb">
                    <li><a href="{{url('/')}}/editor"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Aktifitas Pengguna</li>
                  </ol>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                  <div class="col-sm-12">

			                <div class="white-box" id="app">

                        <div class="row">
                          <div class="col-sm-6 col-md-6 col-lg-6">
                            <div class="button-box">
                              <button onClick="history.back()" type="button" class="btn btn-primary btn-flat"> <i class="fa fa-undo"></i> Kembali</button>
                              <button @click="resetFilter" type="button" class="btn btn-success btn-flat"> <i class="fa fa-refresh"></i> Refresh</button>
                              {{-- <button @click="refreshTable()" type="button" class="btn btn-success btn-flat"> <i class="fa fa-refresh"></i> Refresh</button> --}}
                              {{-- <button class="btn btn-warning btn-flat" @click="resetFilter"><i class="fa fa-refresh"></i> Reset</button> --}}
                            </div>
                          </div>

                          <div class="col-sm-3 col-md-3 col-lg-3">
                            <div class="form-group">
                              <label for="Date">Filter By Tanggal:</label>
                                <input class="form-control input-daterange-datepicker" type="text" name="daterange1" @keyup="setDate" >
                              <input type="hidden" v-model="filterDate"/>
                            </div>
                          </div>

                          <div class="col-sm-3 col-md-3 col-lg-3">
                            <label for="Date">Filter By Roles:</label>

                            <select class="form-control" name="role" id="role" v-model="filterRole" @change="setRole">
                              @foreach($roles as $key => $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                              @endforeach
                            </select>
                          </div>


                          {{-- <div class="col-sm-3 col-md-3 col-lg-3 ">
                            <label for="Date">Filter By Date:</label>

                            <div class="btn-group">
                              <input type="text" class="form-control" v-model="searchFor" placeholder="search" @keyup.enter="setFilter"/>
                              <button class="btn btn-warning btn-flat" @click="resetFilter"><i class="fa fa-refresh"></i> Reset</button>
                            </div>
                          </div> --}}

                        </div>


                        <div class="box-body">
                                <div class="table-responsive" >

                                    <div :class="[{'data-table': true}, loading]">
                                      <vuetable
                                        ref="vuetable"
                                        api-url="{{ URL::route('editor.userlog.dataApi') }}"
                                        :fields="columns"
                                        :append-params="moreParams"
                                        pagination-path=""
                                        :sort-order="sortOrder"
                                        :per-page="perPage"
                                        detail-row-component=""
                                        detail-row-transition="expand"
                                        track-by="id"
                                        @vuetable:pagination-data="onPaginationData"
                                        @vuetable:loading="showLoader"
                              					@vuetable:loaded="hideLoader"
                                        :css="css.table"
                                        >
                                        <template slot="actions" scope="props">
                                          <div class="btn-group">
                                              <a @click="editRow(props.rowData)"><i class="ti-pencil-alt"></i></a>
                                          </div>
                                        </template>

                                      </vuetable>

                                      <div class="data-table-pagination">
                                				<vuetable-pagination-info ref="paginationInfo"
                                					:info-template="paginationInfoTemplate">
                                				</vuetable-pagination-info>
                                				<vuetable-pagination ref="pagination"
                                					@vuetable-pagination:change-page="onChangePage"
                                					:css="css.pagination">
                                				</vuetable-pagination>
                                			</div>

                                </div>
                            </div>
                          </div>
                      <!-- </div> -->
                  </div>
              </div>
            <!-- </div> -->
          </div>
      </div>
    </div>
</div>
@stop


@section('js')

@stop


@section('customjs')

<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.16.1/axios.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.2.6/vue.min.js"></script>
<script src="https://unpkg.com/vuetable-2@1.6.0"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<script>

  Vue.use(Vuetable)
  var vm = new Vue({

    el: '#app',
    data: {
      loading: '',
      searchFor: '',
      filterDate: '',
      filterRole: '',
      columns: [
			  {
          name: 'username',
          title: 'Username',
          sortField: 'username'
        },
        {
          name: 'first_name',
          title: 'First Name',
          sortField: 'firstname'
        },
        {
          name: 'last_name',
          title: 'Last Name',
          sortField: 'last_name'
        },
        {
          name: 'desc',
          title: 'Description',
        },
        {
          name: 'date.date',
          title: 'Date',
          callback: 'onFormatDate|D MMM YYYY HH:mm:ss'
        }

      ],
      moreParams: {},
      sortOrder: [{
  			field: 'id',
  			direction: 'desc'
  		}],

      css: {
  			table: {
  				tableClass: 'table table-striped',
  				ascendingIcon: 'fa fa-angle-up',
  				descendingIcon: 'fa fa-angle-down',
  		    },
        pagination: {
          wrapperClass: "btn-group",
          activeClass: "active",
          disabledClass: "disabled",
          pageClass: "btn btn-default",
          linkClass: "btn btn-default",
          icons: {
            first: "ti-angle-double-left",
            prev: "ti-angle-left",
            next: "ti-angle-right",
            last: "ti-angle-double-right"
          }
        }
      },

      perPage: 5,
      paginationInfoTemplate: '<strong>Showing record</strong> {from} to {to} from {total} item(s)',
    },
    mounted: function() {
       var self = this;
       $('input[name="daterange1"]').daterangepicker({
            opens: 'left'
          }, function(start, end, label) {
              let date = start.format('YYYY-MM-DD')+'|'+end.format('YYYY-MM-DD')
              self.filterDate = date
        })
   },
    methods:{

			editRow(rowData){
					location.href = "{{url('editor/userbranch')}}" + `/${rowData.id}/edit`
			},
      setDate(val){

        this.moreParams = {
          'filter_date': this.filterDate
        }

        this.$nextTick(function(){
          this.$refs.vuetable.refresh()
        })
      },
      setRole(val){

        this.moreParams = {
          'filter_role': this.filterRole
        }

        this.$nextTick(function(){
          this.$refs.vuetable.refresh()
        })
      },

      setFilter(filterText){

        this.moreParams = {
          'filter' : this.searchFor
        }

        this.$nextTick(function(){
          this.$refs.vuetable.refresh()
        })
      },

      resetFilter(){
        moreParams = {}
        this.searchFor = ''
        this.filterDate = ''
        this.filterRole = ''
        this.setFilter()
      },

      refreshTable(){
        this.$refs.vuetable.refresh()
      },

      showLoader(){
        this.loading = 'loading'
      },

      hideLoader (){
        this.loading = ''
      },

      onPaginationData (tablePagination) {
        this.$refs.paginationInfo.setPaginationData(tablePagination)
        this.$refs.pagination.setPaginationData(tablePagination)
      },
      onChangePage (page) {
        this.$refs.vuetable.changePage(page)
      },
      onInitialized (fields) {
        this.vuetableFields = fields
      },

      onCellClicked (data, field, event) {
        this.$refs.vuetable.toggleDetailRow(data.id)
      },

      onFormatDate(value, formated){
          if(value == null) return ''
          formated = (typeof formated === undefined) ? 'D MMM YYYY HH:mm:ss' : formated
          return moment(value, 'YYYY-MM-DD HH:mm:ss').format(formated)
      },

      onDataReset () {
        this.$refs.paginationInfo.resetData()
        this.$refs.pagination.resetData()
      },


    }

  })

</script>

@stop
