{{-- Modal --}}
<div id="finished" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="detailLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header modal-colored-header bg-success">
                <h4 class="modal-title" id="detailLabel">Menyelesaikan Kegiatan</h4>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <form> 
                        @csrf  
                        <div class="mb-3 col-md-12">
                            <label for="jumlah_km_akhir" class="form-label">KM Akhir - Selesai Kegiatan</label>
                            <input type="number" id="jumlah_km_akhir" name="jumlah_km_akhir" class="form-control @error('jumlah_km_akhir') is-invalid @enderror" value="{{ old('jumlah_km_akhir') }}" >
                            @error('jumlah_km_akhir')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success btn-finished-confirm">Finished</button>
            </div>
        </div>
    </div>
</div>