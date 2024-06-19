/* Menampilkan data ke table */
$(document).ready(function() {
    var table = $('#datatable-kegiatan').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        scrollX: true,
        'bDestroy': true,
        ajax: {
            url: '{{ url()->current() }}',
            type: 'GET',
            /* Menjalankan filter */
            data: function(d) {
                d.status_perjalanan = $('#filter-status-perjalanan').val();
            },
        },
        /* Menampilkan kolom */
        columns: [
            {data: 'nik', name: 'nik'},
            {data: 'karyawan_id', name: 'karyawan_id'},
            {data: 'agenda', name: 'agenda'},
            {data: 'tanggal_kegiatan', name: 'tanggal_kegiatan'},
            {data: 'status_kegiatan', name: 'status_kegiatan'},
            {data: 'action', name: 'action', orderable: false, searchable: false} 
        ],
    });

    /* Trigger action filter */
    $('#filter-button').on('click', function() {
        table.ajax.reload();
    });
    /* Trigger action reset */
    $('#reset-button').on('click', function() {
        $('select').val('').trigger('change');
        table.ajax.reload();
    });
});

/* Trigger action view */
$('#datatable-kegiatan').on('click', '.btn-view', function() {
    var id = $(this).data('id');
    console.log('View button clicked, ID:', id); // Debug log
    $.ajax({
        url: '{{ url()->current() }}' + '/'+ id,
        type: 'GET',
        success: function(data) {
            console.log('Data retrieved:', data); // Debug log
            // Populate modal fields with data
            $('#detail .modal-body').html(
                `<table class="table">
                    <tr>
                        <th style="width: 35%">NIK</th>
                        <td style="width: 65%">${data['NIK']}</td>
                    </tr>
                    <tr>
                        <th>Nama Karyawan</th>
                        <td>${data['Nama Karyawan']}</td>
                    </tr>
                    <tr>
                        <th>Agenda</th>
                        <td>${data['Agenda']}</td>
                    </tr>
                    <tr>
                        <th>Tujuan</th>
                        <td>${data['Tujuan']}</td>
                    </tr>
                    <tr>
                        <th>Tanggal Kegiatan</th>
                        <td>${data['Tanggal Kegiatan']}</td>
                    </tr>
                    <tr>
                        <th>Nama Supir</th>
                        <td>${data['Nama Supir']}</td>
                    </tr>
                    <tr>
                        <th>Nama Mobil</th>
                        <td>${data['Nama Mobil']}</td>
                    </tr>
                    <tr>
                        <th>Nopol</th>
                        <td>${data['Nopol']}</td>
                    </tr>
                    <tr>
                        <th>Status Kegiatan</th>
                        <td>${data['Status Kegiatan']}</td>
                    </tr>
                </table>`
            );
            $('#detail').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error); // Debug log
        }
    });
});