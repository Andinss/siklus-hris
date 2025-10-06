@extends('layouts.editor.master')
@section('title')
    Modul
@stop
@section('content')
    <!-- Content Header (Page header) -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">Modul</h4>
                </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <ol class="breadcrumb">
                        <li><a href="{{ url('/') }}/editor"><i class="fa fa-dashboard"></i> Halaman Utama</a></li>
                        <li class="active">Modul</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>

            <!-- /row -->
            <div class="row">
                <div class="col-sm-12">
                    <!-- <div class="table-responsive"> -->
                    <div class="col-sm-12">

                        <div class="white-box" id="app">
                            <div class="row mb-2">
                                <div class="col-sm-8 col-md-8 col-lg-8">
                                    <div class="button-box">
                                        <button onClick="history.back()" type="button"
                                            class="btn btn-sm btn-outline-dark d-inline-block"> <i
                                                class="fas fa-arrow-left"></i> Kembali</button>
                                        <button @click="refreshTable()" type="button"
                                            class="btn btn-sm btn-outline-success d-inline-block"> <i
                                                class="fas fa-undo"></i> Refresh</button>
                                        <a href="{{ URL::route('editor.module.create') }}" type="button"
                                            class="btn btn-sm btn-secondary d-inline-block"> <i class="fas fa-plus"></i>
                                            Tambah Baru</a>
                                    </div>
                                </div>
                                <div class="col-sm-4 col-md-4 col-lg-4">
                                    <div class="btn-group pull-right">
                                        <input type="text" class="form-control" placeholder="search"
                                            @keyup.enter="setFilter" />
                                        <button class="btn btn-sm btn-warning" @click="resetFilter"><i
                                                class="fa fa-refresh"></i> Reset</button>
                                    </div>
                                </div>
                            </div>
                            <div class="box-body">
                                <div class="table-responsive">

                                    <div :class="[{ 'data-table': true }, loading]">
                                        <vuetable ref="vuetable" api-url="{{ URL::route('editor.module.data') }}"
                                            :fields="columns" :append-params="moreParams" pagination-path=""
                                            :sort-order="sortOrder" :per-page="perPage" detail-row-component=""
                                            detail-row-transition="expand" track-by="id"
                                            @vuetable:pagination-data="onPaginationData" @vuetable:loading="showLoader"
                                            @vuetable:loaded="hideLoader" :css="css.table">
                                            <template slot="actions" scope="props">
                                                <div class="btn-group">
                                                    <a class="btn btn-sm btn-outline-primary d-inline-block"
                                                        @click="editRow(props.rowData)"><i class="fas fa-pen"></i>
                                                        Edit</a>&nbsp;
                                                    <a class="btn btn-sm btn-outline-danger d-inline-block"
                                                        @click="deleteId(props.rowData)"><i class="fas fa-trash-alt"></i>
                                                        Hapus</a>
                                                </div>
                                            </template>
                                        </vuetable>
                                        <div class="data-table-pagination col-md-12">
                                            <div class="row">
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="pull-left">
                                                        <vuetable-pagination-info ref="paginationInfo"
                                                            :info-template="paginationInfoTemplate">
                                                        </vuetable-pagination-info>
                                                    </div>
                                                </div>
                                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                                                    <div class="pull-right">
                                                        <vuetable-pagination ref="pagination"
                                                            @vuetable-pagination:change-page="onChangePage"
                                                            :css="css.pagination">
                                                        </vuetable-pagination>
                                                    </div>
                                                </div>
                                            </div>
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

@section('customjs')
    <script>
        Vue.use(Vuetable)
        var vm = new Vue({

            el: '#app',
            data: {
                loading: '',
                searchFor: '',
                columns: [
                    // {
                    //   name: 'id',
                    //   title: '#',
                    //   sortField: 'id'
                    // },
                    {
                        name: '__slot:actions',
                        title: 'Aksi'
                    },
                    {
                        name: 'name',
                        title: 'Name',
                        sortField: 'name'

                    },
                    {
                        name: 'description',
                        title: 'Keterangan',
                        sortField: 'description'

                    },

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

                perPage: 10,
                paginationInfoTemplate: '<strong>Showing record</strong> {from} to {to} from {total} item(s)',
            },

            methods: {

                editRow(rowData) {
                    location.href = "{{ url('editor/module') }}" + `/${rowData.id}/edit`
                },

                setFilter(filterText) {

                    this.moreParams = {
                        'filter': this.searchFor
                    }

                    this.$nextTick(function() {
                        this.$refs.vuetable.refresh()
                    })
                },

                resetFilter() {
                    moreParams = {}
                    this.searchFor = ''
                    this.setFilter()
                },

                refreshTable() {
                    this.$refs.vuetable.refresh()
                },

                showLoader() {
                    this.loading = 'loading'
                },

                hideLoader() {
                    this.loading = ''
                },

                onPaginationData(tablePagination) {
                    this.$refs.paginationInfo.setPaginationData(tablePagination)
                    this.$refs.pagination.setPaginationData(tablePagination)
                },
                onChangePage(page) {
                    this.$refs.vuetable.changePage(page)
                },
                onInitialized(fields) {
                    this.vuetableFields = fields
                },

                onCellClicked(data, field, event) {
                    this.$refs.vuetable.toggleDetailRow(data.id)
                },

                onFormatDate(value, formated) {
                    if (value == null) return ''
                    formated = (typeof formated === undefined) ? 'D MMM YYYY' : formated
                    return moment(value, 'YYYY-MM-DD').format(formated)
                },

                onDataReset() {
                    this.$refs.paginationInfo.resetData()
                    this.$refs.pagination.resetData()
                },

                deleteId(rowData) {
                    $.confirm({
                        title: 'Confirm!',
                        content: 'Are you sure to delete data?',
                        type: 'red',
                        typeAnimated: true,
                        buttons: {
                            cancel: {
                                action: function() {}
                            },
                            confirm: {
                                text: 'DELETE',
                                btnClass: 'btn-red',
                                action: function() {
                                    console.log(this.$refs)
                                    $.ajax({
                                        url: "{{ url('editor/module') }}" +
                                            `/delete/${rowData.id}`,
                                        type: "DELETE",
                                        data: {
                                            '_token': $('input[name=_token]').val()
                                        },
                                        success: function(data) {
                                            var options = {
                                                "positionClass": "toast-bottom-right",
                                                "timeOut": 1000,
                                            };
                                            toastr.success('Successfully deleted data!',
                                                'Success Alert', options);
                                            location.reload();
                                        },
                                        error: function(jqXHR, textStatus, errorThrown) {
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
                },


            }

        })
    </script>

@stop
