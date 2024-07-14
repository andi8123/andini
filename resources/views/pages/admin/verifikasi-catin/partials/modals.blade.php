<x-mollecules.modal id="verifikasi-create-modal"
    action="{{ route('catin.verifikasi-dispensasi.store', $verifikasi_catin->id) }}" hasCloseBtn="true">
    <x-slot:title>Verifikasi Dispensasi</x-slot:title>
    <div class="mb-3">
        <x-atoms.form-label for="assesor_id" required>Assesor</x-atoms.label>
            <x-atoms.select2 placeholder="Pilih Assesor" name="assesor_id" id="assesor_id" class="form-select w-150px"
                label="Assesor" :source="route('reference.assesor')" />
    </div>
    <div class="mb-3">
        <x-atoms.form-label for="tanggal_assesmen_field" required>Tanggal Assesmen</x-atoms.label>
            <x-atoms.input type="datetime-local" id="tanggal_assesmen_field" name="tanggal_assesmen"
                class="form-control" />
    </div>
    {{-- <div class="mb-3">
        <x-atoms.form-label for="catatan" required>Catatan</x-atoms.label>
            <x-atoms.textarea id="catatan" name="catatan" placeholder="Masukkan Catatan"></x-atoms.textarea>
    </div> --}}
    <div class="mb-3">
        <x-atoms.form-label for="status_persetujuan" required>Status kelengkapan administrasi dispensasi
            nikah</x-atoms.label>
            <x-atoms.select id="status_persetujuan" name="status_persetujuan" :lists="[
                'APPROVED' => 'Disetujui',
                'REJECTED' => 'Ditolak',
            ]"></x-atoms.select>
    </div>
    {{-- <div class="mb-3">
        <x-atoms.form-label for="keterangan" required>Keterangan</x-atoms.label>
            <x-atoms.textarea id="keterangan" name="keterangan" placeholder="Masukkan Keterangan"></x-atoms.textarea>
    </div> --}}
    <x-slot:footer>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot:footer>
</x-mollecules.modal>

<x-mollecules.modal id="reset-create-modal"
    action="{{ route('catin.verifikasi-dispensasi.reset', $verifikasi_catin->id) }}" hasCloseBtn="true">
    <x-slot:title>Reset Dispensasi</x-slot:title>
    <p class="text-left">Apakah anda yakin ingin mereset Dispensasi?</p>
    <x-slot:footer>
        <button type="submit" class="btn btn-primary">Reset</button>
    </x-slot:footer>
</x-mollecules.modal>


<x-mollecules.modal id="generate-modal" action="{{ route('catin.generate-dispensasi', $verifikasi_catin->id) }}"
    hasCloseBtn="true">
    <x-slot:title>Input surat dispensasi nikah</x-slot:title>
    <div class="mb-3">
        <x-atoms.form-label for="nomor_surat_field" required>Nomor Surat</x-atoms.label>
            <x-atoms.input type="text" id="nomor_surat_field" name="nomor_surat" class="form-control"
                placeholder="Masukkan Nomor Surat" />
    </div>
    <div class="mb-3">
        <x-atoms.form-label for="file" required>File Surat</x-atoms.label>
            <x-atoms.dropzone id="file" name="file" placeholder="Masukkan File Surat"></x-atoms.dropzone>
            <div class="mb-3" style="font-weight: 300 !important;">
                <small>(File surat dispensasi yang dapat diupload memiliki ketentuan berupa format PDF
                    dengan ukuran
                    maksimal 2 MB)</small>
            </div>
    </div>
    <x-slot:footer>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot:footer>
</x-mollecules.modal>
