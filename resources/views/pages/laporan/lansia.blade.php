@extends('layouts.master')

@section('title', "Laporan")

@section('page-style')
    <style>
        #table_body-view tr td{
            vertical-align: middle;
        }

        #table-participant thead tr th{
            vertical-align: middle;
        }
    </style>
@endsection

@section('page-script')
<script>
    const event_lists = @json($event_lists);

    const table_participant = $("#table-participant").DataTable();

    const table_event = $('#table-event').DataTable({
        data: event_lists,
        scrollX: true,
        scrollCollapse: true,
        deferRender: true,
        processing: true,
        columns: [{
                data: null
            },
            {
                data: "event_day",
            },
            {
                data: "participants",
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
                searchable: true,
                sortable: true,
                targets: 2,
                data: null,
                render: function(data) {
                    return data.length
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
                        <div title="Hadir" class="btn btn-sm btn-outline-primary p-0 px-2 btn-print">
                            <i class="fa fa-print"></i>
                        </div>
                        <div title="Edit" class="btn btn-sm btn-outline-primary p-0 px-2 btn-view">
                            <i class="fa fa-eye"></i>
                        </div>
                    </div>
                    `;
                }
            }
        ]
    });

    function buildTableBody(data){
        $("#event_date-print").text(data.event_day);
        let tbodyHtml = "";
        data.participants.forEach((element, index) => {
            const birthday = new Date(element.detail.birthday);
            const now = new Date();
            let umur = now.getFullYear() - birthday.getFullYear();
            // if ((now.getFullYear() - birthday.getFullYear()) != 0){
            //     umur += 12 * (now.getFullYear() - birthday.getFullYear());
            // }

            let immunizations = "";
            element.detail.immunizations.forEach((val, i) => {
                if (i != 0) {
                    immunizations += " / "
                }
                immunizations += val.detail.code
            });

            tbodyHtml += `
            <tr>
                <td>${index+1}</td>
                <td>${element.detail.full_name}</td>
                <td>${element.detail.birthday}</td>
                <td>${umur}</td>
                <td>${element.detail.parent.full_name}</td>
                <td>${element.weight}</td>
                <td>${element.height}</td>
                <td>${immunizations}</td>
            </tr>
            `
        });

        return tbodyHtml;
    }

    $('#table-event tbody').on('click', '.btn-view', function() {
        const data = table_event.row($(this).parents('tr')).data();
        const tbodyHtml = buildTableBody(data);

        $("#table-participant").DataTable().destroy();
        $("#table_body-view").html(tbodyHtml);
        $("#table-participant").DataTable().draw();

        $("#table_body-print").html(tbodyHtml);

        $("#modal-view").modal("show");
    });

    $('#table-event tbody').on('click', '.btn-print', function() {
        const data = table_event.row($(this).parents('tr')).data();

        const tbodyHtml = buildTableBody(data);
        $("#table_body-print").html(tbodyHtml);

        printJS({
            type: "html",
            printable: "print-area",
            scanStyles: false
        })
    });

    $("#print-view").click( function () {  
        printJS({
            type: "html",
            printable: "print-area",
            scanStyles: false
        })
    } )
</script>
@endsection

@section('content')
<h3>List Posyandu Lansia</h3>
<div class="card p-3">
    <div class="card-datatable table-responsive">
        <table id="table-event" class="w-100 table border-top text-center">
            <thead>
                <tr>
                    <th>No. </th>
                    <th>Tanggal</th>
                    <th>Jumlah Peserta</th>
                    <th>Aksi</th>
                </tr>
            </thead>
        </table>
    </div>
</div>

<div id="modal-view" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detail Peserta</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div style="font-size: 11px" class="modal-body">
                <div class="card-datatable">
                    <table id="table-participant" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th width="5%">No. </th>
                                <th width="25%">Nama</th>
                                <th width="12%">Tgl. Lahir</th>
                                <th width="5%">Umur (Thn)</th>
                                <th width="23%">Nama Wali</th>
                                <th width="5%">BB (Kg)</th>
                                <th width="5%">TB (Kg)</th>
                                <th width="20%">Tambahan</th>
                            </tr>
                        </thead>
                        <tbody id="table_body-view"></tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end mt-3" style="gap: 6px">
                    <button type="button" data-dismiss="modal" aria-label="Close" class="btn btn-dark">Close</button>
                    <button id="print-view" type="button" class="btn btn-primary">Print</button>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Print Area --}}
<div class="mt-3" hidden>
    <div id="print-area">
        <h4 style="text-align: center; margin-bottom: 30px">DAFTAR HADIR LANSIA YANG DATANG KE POSYANDU <br> KECAMATAN LABUHAN RATU 2023</h4>

        <p style="line-height: 10px;font-size: 12px;font-weight: 600">POSYANDU &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            :&nbsp; <span>Mawar 4 Sepang Jaya</span></p>
        <p style="line-height: 10px;font-size: 12px;font-weight: 600">KELURAHAN &nbsp; 
            :&nbsp; <span>Sepang Jaya</span></p>
        <p style="line-height: 10px;font-size: 12px;font-weight: 600">TANGGAL &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
            :&nbsp; <span id="event_date-print">10-04-2023</span></p>
        <table style="margin-top: 15px" border="1" align="center">
            <thead style="font-size: 12px">
                <tr>
                    <th width="5%">No. </th>
                    <th width="25%">Nama</th>
                    <th width="12%">Tgl. Lahir</th>
                    <th width="5%">Umur (Thn)</th>
                    <th width="23%">Nama Wali</th>
                    <th width="5%">BB (Kg)</th>
                    <th width="5%">TB (Kg)</th>
                    <th width="20%">Tambahan</th>
                </tr>
            </thead>
            <tbody style="font-size: 12px;" align="center" id="table_body-print">
                <tr>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                    <td>1</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection