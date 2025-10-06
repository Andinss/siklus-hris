@extends('layouts.editor.template')
@section('module', 'Setting')
@section('title', 'Formulir Komponen Gaji')
@section('content')
    <style type="text/css">
        .dataTables_length {
            margin-top: 12px;
            margin-bottom: 12px !important;
        }
    </style>
    <!-- Page Content -->
    <div id="page-wrapper">
        <div class="container-fluid">
            <div class="row align-items-center bg-title">
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
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-info">
                        <div class="panel-wrapper collapse in" aria-expanded="true">
                            <div class="panel-body">
                                <div class="form-body">
                                    <section>
                                        @if (isset($payrollComponent))
                                            {!! Form::model($payrollComponent, [
                                                'route' => ['editor.payroll-component.update', $payrollComponent->id],
                                                'method' => 'PUT',
                                                'files' => 'true',
                                            ]) !!}
                                        @else
                                            {!! Form::open(['route' => 'editor.payroll-component.store']) !!}
                                        @endif
                                        {{ csrf_field() }}
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    {{ Form::label('category_name', 'Nama Kategori') }}
                                                    {{ Form::text('category_name', old('category_name'), ['class' => 'form-control', 'placeholder' => 'Nama Kategori', 'required' => 'true', 'id' => 'category_name']) }}
                                                </div>
                                            </div>
                                            <div id="componentLists" class="col-md-6">
                                                <div class="row align-items-center px-2 mb-3">
                                                    <div class="col-9 px-2">
                                                        {{ Form::label('component_list', 'Item Komponen') }}
                                                    </div>
                                                    <div class="col-3 px-2">
                                                        <button type="button" id="btnAddComponent"
                                                            class="btn btn-sm btn-block btn-info mb-0"><i
                                                                class="fa fa-plus"></i> Tambah</button>
                                                    </div>
                                                </div>
                                                <!-- Component Item -->
                                                <div id="component_item_0"
                                                    class="componentItem row align-items-center px-2 mb-3">
                                                    <div class="col-9 px-2">
                                                        {{ Form::text('component_name[]', old('component_name_0'), ['class' => 'componentInputName form-control', 'placeholder' => 'Nama Komponen', 'required' => 'true', 'id' => 'component_name_0']) }}
                                                    </div>
                                                    <div class="col-3 px-2">
                                                        <a onclick="removeComponent('component_item_0', 'component_name_0')"
                                                            class="btnRemoveComponent btn btn-sm btn-block btn-danger mb-0"><i
                                                                class="fa fa-trash"></i> Hapus</a>
                                                    </div>
                                                </div>
                                                <!-- End Component Item -->
                                            </div>
                                        </div>
                                        <button type="submit" id="btnsave" class="btn btn-success pull-right"><i
                                                class="fa fa-check"></i> Simpan</button>
                                        <a href="{{ URL::route('editor.payroll-component.index') }}"
                                            class="btn btn-default btn-flat pull-right" style="margin-right: 10px"><i
                                                class="fa fa-close"></i> Tutup</a>
                                        {!! Form::close() !!}
                                    </section>
                                </div>
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
    <script type="text/javascript">
        $(document).ready(function() {
            // $("#component_name_1").val('Gaji Pokok');
            addComponentItem();

            if (@json(isset($payrollComponentDetails))) {
                dynamicComponent(@json($payrollComponentDetails ?? []))
            }
        });

        // Add Component Item
        function addComponentItem() {
            let componentItemIndex = 0;
            $("#btnAddComponent").on("click", function() {
                componentItemIndex += 1;
                let newComponentItem = `
        <div id="component_item_${componentItemIndex}" class="componentItem row align-items-center px-2 mb-3">
          <div class="col-9 px-2">
          {{ Form::text('component_name[]', old('component_name_${componentItemIndex}'), ['class' => 'componentInputName form-control', 'placeholder' => 'Nama Komponen', 'required' => 'true', 'id' => 'component_name_${componentItemIndex}']) }}
          </div>
          <div class="col-3 px-2">
            <a onclick="removeComponent('component_item_${componentItemIndex}', 'component_name_${componentItemIndex}')" class="btnRemoveComponent btn btn-block btn-danger mb-0"><i class="fa fa-trash"></i> Hapus</a>
          </div>
        </div>
      `;
                $("#componentLists").append(newComponentItem);
            });
        }

        // Dynamic Component Item
        function dynamicComponent(data) {
            if (data && data.length > 0) {
                let componentItem = '';
                let componentItemIndex = 0;

                data.forEach(element => {
                    // console.log(element.payroll_component_name);
                    componentItemIndex += 1;
                    componentItem += `
            <div id="component_item_${componentItemIndex}" class="componentItem row align-items-center px-2 mb-3">
              <div class="col-9 px-2">
              {{ Form::text('component_name[]', old('component_name_${componentItemIndex}', '${element.payroll_component_name}'), ['class' => 'componentInputName form-control', 'placeholder' => 'Nama Komponen', 'required' => 'true', 'id' => 'component_name_${componentItemIndex}']) }}
              </div>
              <div class="col-3 px-2">
                <a onclick="removeComponent('component_item_${componentItemIndex}', 'component_name_${componentItemIndex}')" class="btnRemoveComponent btn btn-block btn-danger mb-0"><i class="fa fa-trash"></i> Hapus</a>
              </div>
            </div>
          `;
                });

                $("#componentLists").html(componentItem);
            }
        }

        // Remove Component Item
        function removeComponent(item_id, input_id) {
            let component_item = $(`#componentLists > #${item_id}.componentItem`);
            const component_input = $(`#${input_id}.componentInputName`).val();
            if (component_input == "Gaji Pokok" || component_input == "Lembur" || component_input ==
                "BPJS Ketenagakerjaan" || component_input == "BPJS Kesehatan") {
                return;
            } else {
                component_item.remove();
            }
        }
    </script>
@stop
