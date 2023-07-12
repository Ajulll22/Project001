@extends('layouts.master')

@section('title', "Dashboard")

@section('page-script')
    <script>
        const select2 = $(".select2");
        if (select2.length) {
            select2.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Pilih ',
                    dropdownParent: $this.parent()
                });
            });
        }
    </script>
    <script>
        let present_list = @json($list_participants["present"]);
        let not_present_list = @json($list_participants["not_present"]);

        let parent_list = @json($list_parents);

        let privHtml = "";

        async function refreshParent() {  
            const parentSelect2 = $(".parent-select2");
            if (parentSelect2.length) {
                parentSelect2.each(function() {
                    var $this = $(this);
                    $this.wrap('<div class="position-relative"></div>').select2({
                        placeholder: 'Pilih ',
                        dropdownParent: $this.parent(),
                        data: parent_list
                    });
                });
            }
        }
        refreshParent();

        const table_not_present = $('#table-not-present').DataTable({
            data: not_present_list,
            scrollX: true,
            scrollCollapse: true,
            deferRender: true,
            processing: true,
            columns: [{
                    data: null
                },
                {
                    data: "full_name",
                },
                {
                    data: "birthday",
                },
                {
                    data: "gender",
                },
                {
                    data: "address",
                },
                {
                    data: null
                }
            ],
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthLabel: '_LABEL_ items/page',
            },
            columnDefs: [{
                    searchable: false,
                    sortable: true,
                    targets: 0,
                    data: null,
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    searchable: false,
                    sortable: false,
                    targets: -1,
                    data: null,
                    render: function(data) {
                        return `
                        <div class="d-flex justify-content-center" style="gap:6px">
                            <div title="Hadir" class="btn btn-sm btn-outline-success p-0 px-2 form_present-show">
                                <i class="fa fa-check"></i>
                            </div>
                            <div title="Edit" class="btn btn-sm btn-outline-primary p-0 px-2 form_edit-show">
                                <i class="fa fa-pencil-alt"></i>
                            </div>
                            <div title="Hapus" class="btn btn-sm btn-outline-danger p-0 px-2 delete-data">
                                <i class="fa fa-trash"></i>
                            </div>
                        </div>
                        `;
                    }
                }
            ]
        });

        const table_present = $('#table-present').DataTable({
            data: present_list,
            scrollX: true,
            scrollCollapse: true,
            deferRender: true,
            processing: true,
            columns: [{
                    data: null
                },
                {
                    data: "full_name",
                },
                {
                    data: "birthday",
                },
                {
                    data: "gender",
                },
                {
                    data: "address",
                },
                {
                    data: null
                }
            ],
            responsive: true,
            language: {
                searchPlaceholder: 'Search...',
                sSearch: '',
                lengthLabel: '_LABEL_ items/page',
            },
            columnDefs: [{
                    searchable: false,
                    sortable: true,
                    targets: 0,
                    data: null,
                    render: function(data, type, full, meta) {
                        return meta.row + 1;
                    }
                },
                {
                    searchable: false,
                    sortable: false,
                    targets: -1,
                    data: null,
                    render: function(data) {
                        return `
                        <div class="d-flex justify-content-center" style="gap:6px">
                            <div title="Edit" class="form_present_update-show btn btn-sm btn-outline-primary p-0 px-2">
                                <i class="fa fa-pencil-alt"></i>
                            </div>
                        </div>
                        `;
                    }
                }
            ]
        });

        $("#form_add-show").click( function () {  
            $("#form-add")[0].reset();

            $("#select-parent-add").val("").change();
            $("#gender-add").val("").change();
            $("#select-parent-add").attr("name", "parent_id");
            $("#input-parent-add").prop("required", false);
            $("#select-parent-add").prop("required", true);
            $("#input-parent-add").removeAttr("name");
            $("#parent-select-add").show();
            $("#parent-input-add").hide();
            $("#parent-action-add").html(`<div class="btn btn-primary">New</div>`)
            $("#modal-add").modal("show");
        } )

        $('#table-not-present tbody').on('click', '.form_present-show', function() {
            const data = table_not_present.row($(this).parents('tr')).data();
            console.log(data);
            $("#weight-present").val("");
            $("#height-present").val("");
            $("#form-present input:checkbox[name=immunizations]").prop("checked", false);

            $("#id-present").val(data.id);
            if (data.detail) {
                $("#weight-present").val(data.detail.weight);
                $("#height-present").val(data.detail.height);
            }
            
            if (data.immunizations.length) {
                data.immunizations.forEach(element => {
                    $(`#immunization-${element.immunization_id}`).prop("checked", true);
                });
            }

            $("#modal-present").modal("show");

        })

        $('#table-not-present tbody').on('click', '.form_edit-show', function() {
            const data = table_not_present.row($(this).parents('tr')).data();

            $("#select-parent-edit").val(data.parent_id).change();
            $("#id-edit").val(data.id);
            $("#full_name-edit").val(data.full_name);
            $("#gender-edit").val(data.gender).change();
            $("#birthday-edit").val(data.birthday);
            $("#address-edit").val(data.address);


            $("#select-parent-edit").attr("name", "parent_id");
            $("#input-parent-edit").prop("required", false);
            $("#select-parent-edit").prop("required", true);
            $("#input-parent-edit").removeAttr("name");
            $("#parent-select-edit").show();
            $("#parent-input-edit").hide();
            $("#parent-action-edit").html(`<div class="btn btn-primary">New</div>`)
            $("#modal-edit").modal("show");            
        });

        $('#table-present tbody').on('click', '.form_present_update-show', function() {
            const data = table_present.row($(this).parents('tr')).data();

            $("#form-present_update input:checkbox[name=immunizations]").prop("checked", false);

            $("#id-present_update").val(data.detail.id);
            $("#weight-present_update").val(data.detail.weight);
            $("#height-present_update").val(data.detail.height);

            if (data.immunizations.length) {
                data.immunizations.forEach(element => {
                    $(`#immunization_update-${element.immunization_id}`).prop("checked", true);
                });
            }

            $("#modal-present_update").modal("show");
        })

        $('#table-not-present tbody').on('click', '.delete-data', function() {
            const {id} = table_not_present.row($(this).parents('tr')).data();
            Swal.fire({
                title: 'Apakah kamu yakin?',
                text: "Kamu tidak dapat mengulangi ini!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Batal',
                confirmButtonText: 'Ya, hapus!',
                customClass: {
                    confirmButton: 'btn btn-primary me-3',
                    cancelButton: 'btn btn-label-secondary'
                },
                buttonsStyling: false
            }).then(function(result) {
                if (result.value) {
                    $.LoadingOverlay("show");
                    $.ajax({
                        type: 'DELETE',
                        url: `/remaja/${id}`,
                        datatype: "json",
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        success: function(res) {
                            $.LoadingOverlay("hide");
                            table_not_present.clear().rows.add(res.data.not_present).draw();
                            Swal.fire({
                                icon: res.status,
                                title: 'Success',
                                text: res.message,
                                customClass: {
                                    confirmButton: 'btn btn-success'
                                }
                            })
                        }
                    });
                }
            });
        })

        $("#parent-action-add").click( function () {  
            if ($("#parent-select-add").is(":visible")) {
                $("#input-parent-add").val("");
                $("#input-parent-add").attr("name", "full_name_parent");
                $("#input-parent-add").prop("required", true);
                $("#select-parent-add").prop("required", false);
                $("#select-parent-add").removeAttr("name");
                $("#parent-select-add").hide();
                $("#parent-input-add").show();
                $(this).html(`<div class="btn btn-success">Exist</div>`)
            } else {
                $("#select-parent-add").val("").change()
                $("#select-parent-add").attr("name", "parent_id");
                $("#input-parent-add").prop("required", false);
                $("#select-parent-add").prop("required", true);
                $("#input-parent-add").removeAttr("name");
                $("#parent-select-add").show();
                $("#parent-input-add").hide();
                $(this).html(`<div class="btn btn-primary">New</div>`)
            }
        } );

        $("#parent-action-edit").click( function () {  
            if ($("#parent-select-edit").is(":visible")) {
                $("#input-parent-edit").val("");
                $("#input-parent-edit").attr("name", "full_name_parent");
                $("#input-parent-edit").prop("required", true);
                $("#select-parent-edit").prop("required", false);
                $("#select-parent-edit").removeAttr("name");
                $("#parent-select-edit").hide();
                $("#parent-input-edit").show();
                $(this).html(`<div class="btn btn-success">Exist</div>`)
            } else {
                $("#select-parent-edit").attr("name", "parent_id");
                $("#input-parent-edit").prop("required", false);
                $("#select-parent-edit").prop("required", true);
                $("#input-parent-edit").removeAttr("name");
                $("#parent-select-edit").show();
                $("#parent-input-edit").hide();
                $(this).html(`<div class="btn btn-primary">New</div>`)
            }
        } );

        $("#form-add").submit( function (e) {  
            e.preventDefault();
            $.LoadingOverlay("show");

            const data = {};
            $("form#form-add :input").each(function() {
                let nama = $(this).attr("name");
                let value = $(this).val();
                if (nama) {
                    data[nama] = value || null;
                }
            });

            $.ajax({
                url: '{{ route("remaja_store") }}',
                method: 'POST',
                data,
                datatype: "json",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(res) {
                    $.LoadingOverlay("hide");
                    table_not_present.clear().rows.add(res.data.not_present).draw();
                    parent_list = res.data.parents;
                    refreshParent();
                    $("#modal-add").modal("hide");
                    Swal.fire({
                        icon: res.status,
                        title: 'Success',
                        text: res.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    })
                }
            });

        } )

        $("#form-edit").submit( function (e) {  
            e.preventDefault();
            $.LoadingOverlay("show");

            const data = {};
            $("form#form-edit :input").each(function() {
                let nama = $(this).attr("name");
                let value = $(this).val();
                if (nama) {
                    data[nama] = value || null;
                }
            });

            $.ajax({
                url: `/remaja/${data.id}`,
                method: 'PUT',
                data,
                datatype: "json",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(res) {
                    $.LoadingOverlay("hide");
                    table_not_present.clear().rows.add(res.data.not_present).draw();
                    parent_list = res.data.parents;
                    refreshParent();
                    $("#modal-edit").modal("hide");
                    Swal.fire({
                        icon: res.status,
                        title: 'Success',
                        text: res.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    })
                }
            });
        } )

        $("#form-present").submit( function (e) {  
            e.preventDefault()
            $.LoadingOverlay("show");
            const immunizations = [];
            $("#form-present input:checkbox[name=immunizations]:checked").each(function() {
                immunizations.push($(this).val());
            });
            const data = {};
            $("form#form-present :input").each(function() {
                let nama = $(this).attr("name");
                let value = $(this).val();
                if (nama) {
                    data[nama] = value || null;
                }
            });
            data.immunizations = immunizations;

            $.ajax({
                url: "{{ route('remaja_present') }}",
                method: 'POST',
                data,
                datatype: "json",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(res) {
                    $.LoadingOverlay("hide");
                    console.log(res);
                    table_not_present.clear().rows.add(res.data.not_present).draw();
                    table_present.clear().rows.add(res.data.present).draw();
                    $("#modal-present").modal("hide");
                    Swal.fire({
                        icon: res.status,
                        title: 'Success',
                        text: res.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    })
                }
            });
        } )

        $("#form-present_update").submit( function (e) {  
            e.preventDefault()
            $.LoadingOverlay("show");
            const immunizations = [];
            $("#form-present_update input:checkbox[name=immunizations]:checked").each(function() {
                immunizations.push($(this).val());
            });
            const data = {};
            $("form#form-present_update :input").each(function() {
                let nama = $(this).attr("name");
                let value = $(this).val();
                if (nama) {
                    data[nama] = value || null;
                }
            });
            data.immunizations = immunizations;
            $.ajax({
                url: `/remaja/present/${data.id}`,
                method: 'PUT',
                data,
                datatype: "json",
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(res) {
                    $.LoadingOverlay("hide");
                    console.log(res);
                    table_present.clear().rows.add(res.data.present).draw();
                    $("#modal-present_update").modal("hide");
                    Swal.fire({
                        icon: res.status,
                        title: 'Success',
                        text: res.message,
                        customClass: {
                            confirmButton: 'btn btn-success'
                        }
                    })
                }
            });
        } )

    </script>
@endsection

@section('content')
    <div class="d-flex justify-content-between mb-3">
        <h3 class="my-auto">List Remaja</h3>
        <ul style="gap: 4px" class="nav nav-pills" role="tablist">
            <li class="nav-item active me-1">
                <a class="nav-link p-1 px-2 active" title="List Tree" data-toggle="tab"
                    href="#list-tree" aria-controls="list-tree" aria-selected="false"><i
                        class='fa fa-list-ul'></i></a>
            </li>
            <li class="nav-item">
                <a class="nav-link p-1 px-2" title="List Row" data-toggle="tab"
                    href="#list-card" aria-controls="list-card" aria-selected="false"><i
                        class='fa fa-check'></i></a>
            </li>
        </ul>
    </div>

    <div class="tab-content mt-2 px-0">
        <div class="tab-pane fade active show" id="list-tree" role="tabpanel">
            <div class="card p-3">
                <div class="d-flex mb-3">
                    <div id="form_add-show" class="btn btn-primary btn-sm my-auto"><i class="fa fa-plus"></i> Tambah Peserta Baru</div>
                </div>
                <div class="card-datatable table-responsive">
                    <table id="table-not-present" class="w-100 table border-top">
                        <thead>
                            <tr>
                                <th>No. </th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade active" id="list-card" role="tabpanel">
            <div class="card p-3">
                <div class="card-datatable">
                    <table id="table-present" class="table border-top w-100">
                        <thead>
                            <tr>
                                <th>No. </th>
                                <th>Nama</th>
                                <th>Tanggal Lahir</th>
                                <th>Jenis Kelamin</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-add" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Peserta Baru</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-add" autocomplete="off">
                        <label for="recipient-name" class="col-form-label">Wali/Orang Tua:</label>
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex" style="gap: 4px">
                                <div id="parent-input-add" class="w-100" style="display: none">
                                    <input id="input-parent-add" placeholder="Nama Lengkap Wali" type="text" class="form-control">
                                </div>
                                <div id="parent-select-add" class="w-100">
                                    <select id="select-parent-add" name="parent_id" class="form-control select2 parent-select2">
                                      <option value="">Pilih Wali</option>
                                    </select>
                                </div>
                                <div id="parent-action-add">
                                    <div class="btn btn-primary">New</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Nama Lengkap:</label>
                                  <input name="full_name" placeholder="Nama Lengkap" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Jenis Kelamin:</label>
                                  <select id="gender-add" name="gender" class="form-control select2" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki">Laki-Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Tanggal Lahir:</label>
                                  <input name="birthday" type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Alamat:</label>
                                    <textarea name="address" class="form-control" name="description" placeholder="Alamat"
                                        rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2" style="gap: 6px">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-dark">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-edit" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Peserta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-edit" autocomplete="off">
                        <input type="text" name="id" id="id-edit" hidden>
                        <label for="recipient-name" class="col-form-label">Wali/Orang Tua:</label>
                        <div class="row mb-3">
                            <div class="col-md-12 d-flex" style="gap: 4px">
                                <div id="parent-input-edit" class="w-100" style="display: none">
                                    <input id="input-parent-edit" placeholder="Nama Lengkap Wali" type="text" class="form-control">
                                </div>
                                <div id="parent-select-edit" class="w-100">
                                    <select id="select-parent-edit" name="parent_id" class="form-control select2 parent-select2">
                                      <option value="">Pilih Wali</option>
                                    </select>
                                </div>
                                <div id="parent-action-edit">
                                    <div class="btn btn-primary">New</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Nama Lengkap:</label>
                                  <input name="full_name" id="full_name-edit" placeholder="Nama Lengkap" type="text" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Jenis Kelamin:</label>
                                  <select name="gender" id="gender-edit" class="form-control select2" required>
                                    <option value="">Pilih Jenis Kelamin</option>
                                    <option value="laki-laki">Laki-Laki</option>
                                    <option value="perempuan">Perempuan</option>
                                  </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                  <label for="recipient-name" class="col-form-label">Tanggal Lahir:</label>
                                  <input name="birthday" id="birthday-edit" type="date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="" class="col-form-label">Alamat:</label>
                                    <textarea name="address" id="address-edit" class="form-control" name="description" placeholder="Alamat"
                                        rows="4"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2" style="gap: 6px">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-dark">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-present" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Data Perkembangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-present" autocomplete="off">
                        <input id="id-present" name="participant_id" type="text" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-form-label">Berat Badan:</label>
                                  <input name="weight" id="weight-present" placeholder="Berat Badan" type="number" step="0.01" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-form-label">Tinggi Badan:</label>
                                  <input name="height" id="height-present" placeholder="Tinggi Badan" type="number" step="0.01" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Immunisasi:</label>
                            <div style="flex-wrap: wrap" class="d-flex border p-2">
                                @foreach ($list_immunizations as $immunization)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="immunizations" type="checkbox" value="{{$immunization->id}}" id="immunization-{{$immunization->id}}">
                                            <label class="form-check-label" for="immunization-{{$immunization->id}}">
                                                {{$immunization->name}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2" style="gap: 6px">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-dark">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="modal-present_update" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Data Perkembangan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form-present_update" autocomplete="off">
                        <input id="id-present_update" name="id" type="text" hidden>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-form-label">Berat Badan:</label>
                                  <input name="weight" id="weight-present_update" placeholder="Berat Badan" type="number" step="0.01" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                  <label class="col-form-label">Tinggi Badan:</label>
                                  <input name="height" id="height-present_update" placeholder="Tinggi Badan" type="number" step="0.01" class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-form-label">Immunisasi:</label>
                            <div style="flex-wrap: wrap" class="d-flex border p-2">
                                @foreach ($list_immunizations as $immunization)
                                    <div class="col-md-6">
                                        <div class="form-check">
                                            <input class="form-check-input" name="immunizations" type="checkbox" value="{{$immunization->id}}" id="immunization_update-{{$immunization->id}}">
                                            <label class="form-check-label" for="immunization_update-{{$immunization->id}}">
                                                {{$immunization->name}}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-2" style="gap: 6px">
                            <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-dark">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection