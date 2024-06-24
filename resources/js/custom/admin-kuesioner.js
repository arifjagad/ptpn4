/* Menampilkan data ke table */
$(document).ready(function() {
    var table = $('#datatable-admin-kuesioner').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        scrollX: true,
        'bDestroy': true,
        ajax: {
            url: '/admin/list-kuesioner/',
            type: 'GET',
            /* Menjalankan filter */
            data: function(d) {
                d.status_kuesioner = $('#filter-status-kuesioner').val();
            },
        },
        /* Menampilkan kolom */
        columns: [
            {data: 'nama_karyawan', name: 'nama_karyawan'},
            {data: 'agenda', name: 'agenda'},
            {data: 'status_kuesioner', name: 'status_kuesioner'},
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