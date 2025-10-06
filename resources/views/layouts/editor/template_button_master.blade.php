<div class="row justify-content-end px-2">
    @if ($back_button === true)
        <div class="col-sm-12 col-md-2 mb-3 mb-md-0 px-2">
            <a href="#" onClick="history.back()" type="button" class="btn btn-outline-dark">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    @endif
    <div class="col-sm-12 col-md-10 px-2">
        <div class="row justify-content-end">
            <div class="col-4 col-sm-5 col-md-3 col-xl-2 px-2">
                <a href="#" onClick="reload_table()" type="button" class="btn btn-outline-primary">
                    <i class="fas fa-undo"></i> Refresh
                </a>
            </div>
            @if ($add_action != 'null')
                <div class="col-6 col-sm-6 col-md-4 col-lg-3 col-xl-2 px-2">
                    @if ($add_action == 'link')
                        <a href="{{ URL::route($link) }}" type="button" class="btn btn-secondary">
                            <i class="fas fa-plus"></i> Tambah Baru
                        </a>
                    @elseif($add_action == 'modal')
                        <a href="#" onClick="{{ $add_function }}" alt="target modal" type="button"
                            class="btn btn-secondary">
                            <i class="fas fa-plus"></i> Tambah Baru
                        </a>
                    @elseif($add_action == 'default')
                        <a href="#" onclick="add()" alt="default" data-toggle="modal" data-target="#modal_form"
                            type="button" class="btn btn-secondary">
                            <i class="fas fa-plus"></i> Tambah Baru
                        </a>
                    @endif
                </div>
            @endif
            @if ($info_button === true)
                <div class="col-2 col-sm-1 px-2">
                    <a href="#" onClick="showslip('{{ Request::segment(2) }}');" type="button"
                        class="btn btn-outline-warning">?</a>
                </div>
            @endif
        </div>
    </div>
</div>
