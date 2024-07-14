    <x-mollecules.modal id="verifikasi-jadwal-asesmen-modal" action="/asesmen/jadwal-asesmen/verify/{id}"
        :hasCloseBtn="false" method="PUT" tableId="jadwalasesmen-table" data-table-id="jadwalasesmen-table">
        @csrf

        <x-slot:title>Verifikasi Persetujuan Asesmen Dispensasi</x-slot:title>
        <div>
            <div class="mt-2">
                <x-atoms.form-label>Keterangan</x-atoms.form-label>
                <x-atoms.textarea name="keterangan" id="keterangan" class="form-control"></x-atoms.textarea>
            </div>
            <div class="mt-2">
                <x-atoms.form-label for="status_field" required>Status Verifikasi</x-atoms.form-label>
                <x-mollecules.radio-group name="status" value="APPROVED" :lists="[
                    'APPROVED' => 'Diterima',
                    'REJECTED' => 'Ditolak',
                ]"></x-mollecules.radio-group>
            </div>
        </div>
        <x-slot:footer>
            <div class="d-flex w-100 justify-content-between">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button class="btn-primary btn" type="submit" data-text="Save" data-text-loading="Saving">Simpan
                    Verifikasi</button>
            </div>
        </x-slot:footer>
    </x-mollecules.modal>
