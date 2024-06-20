/* Menampilkan data ke table */
$(document).ready(function() {
    var table = $('#datatable-kegiatan').DataTable({
        processing: true,
        serverSide: true,
        ordering: false,
        scrollX: true,
        'bDestroy': true,
        ajax: {
            url: '/mandor/kegiatan/',
            type: 'GET',
            /* Menjalankan filter */
            data: function(d) {
                d.status_kegiatan = $('#filter-status-kegiatan').val();
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
    var targetModal = $(this).data('bs-target');

    // Hide all other modals
    $.ajax({
        url: '/mandor/kegiatan/'+ id,
        type: 'GET',
        success: function(data) {
            console.log('Data retrieved:', data); // Debug log
            // Check which modal to show
            if (targetModal === '#detail') {
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
                        <tr>
                            <th>KM Mobil</th>
                            <td>${data['KM awal - KM Akhir']}</td>
                        </tr>
                    </table>`
                );
            }

            // Show the target modal
            $(targetModal).modal('show');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error); // Debug log
        }
    });
});

// Trigger action finished
// $('#datatable-kegiatan').on('click', '.btn-finished', function() {
//     let id = $(this).data('id');
//     if (id === undefined) {
//         console.error('ID tidak ditemukan');
//         return;
//     }
//     console.log(id);
//     var jumlahKmAwal = $('#jumlah_km_awal').val(); // Ambil nilai KM akhir

//     $.ajax({
//         url: '/mandor/kegiatan/finished/' + id, // Gunakan route yang sesuai
//         method: 'PUT',
//         data: {
//             jumlah_km_akhir: jumlahKmAwal,
//             _token: $('meta[name="csrf-token"]').attr('content') // Perbaiki ini
//         },
//         headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
//         },
//         success: function(response) {
//             // Tutup modal, refresh halaman, atau tampilkan pesan sukses
//             $('#finished').modal('hide');
//             // ...
//         },
//         error: function(error) {
//             // Tangani error jika ada
//         }
//     });
// });

$('#datatable-kegiatan').on('click', '.btn-finished', function() {
    let id = $(this).data('id');
    
    // Set the data-id attribute of the confirmation button in the modal
    $('.btn-finished-confirm').data('id', id);

    $('#jumlah_km_akhir_error').text('');

    // Show the modal
    $('#finished').modal('show');
});

$('.btn-finished-confirm').on('click', function() {
    let id = $(this).data('id');
    var jumlahKmAkhir = $('#jumlah_km_akhir').val();

    if (jumlahKmAkhir === '') {
        $(this).prop('disabled', true);
    } else {
        $(this).prop('disabled', false);

        $.ajax({
            url: '/mandor/kegiatan/finished/' + id,
            method: 'PUT',
            data: {
                jumlah_km_akhir: jumlahKmAkhir,
                _token: $('meta[name="csrf-token"]').attr('content')
            },
            complete: function() {
                // Reload the page after the AJAX request completes
                $('#finished').modal('hide');
                location.reload();
            },
        });
    }
});

$('#jumlah_km_akhir').on('input', function() {
    $('.btn-finished-confirm').prop('disabled', $(this).val() === '');
});
