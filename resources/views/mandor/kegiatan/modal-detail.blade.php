{{-- Modal --}}
<div id="detail" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-info">
                <h4 class="modal-title" id="detailLabel">Detail Kegiatan</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#datatable-kegiatan').on('click', '.btn-view', function() {
    var id = $(this).data('id');
    console.log('View button clicked, ID:', id); // Debug log
    $.ajax({
        url: '{{ url()->current() }}' + '/'+ id,
        type: 'GET',
        success: function(data) {
            console.log('Data retrieved:', data); // Debug log
            // Populate modal fields with data
            $('#detail .modal-body').html(`
                <p><strong>NIK:</strong> ${data.nik}</p>
                <p><strong>Nama Karyawan:</strong> ${data.karyawan_id}</p>
                <p><strong>Agenda:</strong> ${data.agenda}</p>
                <p><strong>Tujuan:</strong> ${data.tujuan}</p>
                <p><strong>Tanggal Kegiatan:</strong> ${data.tanggal_kegiatan}</p>
                <p><strong>Nama Supir:</strong> ${data.supir_id}</p>
                <p><strong>Nama Mobil:</strong> ${data.mobil_id}</p>
                <p><strong>Nopol:</strong> ${data.nopol}</p>
                <p><strong>Status Kegiatan:</strong> ${data.status_kegiatan}</p>
            `);
            $('#detail').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error); // Debug log
        }
    });
});
</script>