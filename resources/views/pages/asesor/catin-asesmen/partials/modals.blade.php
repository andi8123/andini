<x-mollecules.modal id="preview-modal" size="md" hasCloseBtn="true" action="#">
    <x-slot name="title">
        Preview File
    </x-slot>
    <x-slot name="footer">
    </x-slot>
    <div class="preview-container-modal" class="mb-3">
        <img src="{{ asset('assets/media/illustrations/img-preview.png') }}" alt="Default Image"
            class="img-fluid rounded mx-auto d-block" style="max-width: 400px; max-height: 300px;">
    </div>
</x-mollecules.modal>

<x-mollecules.modal id="asesmen-modal" action="/asesor/catin-asesmen/{id}" method="PUT" size="xl">
    <x-slot:title>Asesmen</x-slot:title>
    <div class="row">
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="nama_pemohon" required>
                    Nama Pemohon
                </x-atoms.form-label>
                <x-atoms.input name="nama_pemohon" id="nama_pemohon_1" placeholder="Masukkan Nama Pemohon"
                               :value="$data->asesmen_penilaian->nama_pemohon" />
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="lama-hubungan_field" required>Lama
                    Hubungan</x-atoms.form-label>
                <x-atoms.input name="lama_hubungan" id="lama-hubungan_field" placeholder="Masukkan Lama Hubungan"
                    :value="$data->asesmen_penilaian->lama_hubungan" />
                <div class="mt-1" style="font-weight: 300 !important;">
                    <small>Isi lama hubungan dengan format seperti berikut: <b>1 Tahun 2 Bulan 30 Hari</b></small>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="penghasilan-catin_field" required>Penghasilan
                    Catin</x-atoms.form-label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">Rp.</span>
                    <x-atoms.input type="number" name="penghasilan_catin" id="penghasilan-catin_field" aria-describedby="basic-addon1"
                                   placeholder="Masukkan Penghasilan Catin" :value="$data->asesmen_penilaian->penghasilan_catin" />
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="pekerjaan-catin_field" required>Pekerjaan
                    Catin</x-atoms.form-label>
                <x-atoms.input name="pekerjaan_catin" id="pekerjaan-catin_field" placeholder="Masukkan Pekerjaan Catin"
                    :value="$data->asesmen_penilaian->pekerjaan_catin" />
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="alasan-menikah_field" required>Alasan
                    Menikah</x-atoms.form-label>
                <x-atoms.summernote id="alasan-menikah_field" name="alasan_menikah"
                    placeholder="Masukkan Alasan Menikah">
                    {!! $data->asesmen_penilaian->alasan_menikah !!}
                </x-atoms.summernote>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="gaya-berpacaran_field" required>Gaya
                    Berpacaran</x-atoms.form-label>
                <x-atoms.summernote id="gaya-berpacaran_field" name="gaya_berpacaran"
                    placeholder="Masukkan Gaya Berpacaran">
                    {!! $data->asesmen_penilaian->gaya_berpacaran !!}
                </x-atoms.summernote>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="persetujuan-keluarga_field" required>Persetujuan
                    Keluarga</x-atoms.form-label>
                <x-atoms.summernote id="persetujuan-keluarga_field" name="persetujuan_keluarga"
                    placeholder="Masukkan Persetujuan Keluarga">
                    {!! $data->asesmen_penilaian->persetujuan_keluarga !!}
                </x-atoms.summernote>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="pola-hubungan_field" required>Pola
                    Hubungan</x-atoms.form-label>
                <x-atoms.summernote id="pola-hubungan_field" name="pola_hubungan"
                    placeholder="Masukkan Pola Hubungan">
                    {!! $data->asesmen_penilaian->pola_hubungan !!}
                </x-atoms.summernote>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="catatan_field" required>Catatan</x-atoms.form-label>
                <x-atoms.summernote id="catatan_field" name="catatan" placeholder="Masukkan Catatan">
                    {!! $data->asesmen_penilaian->catatan !!}
                </x-atoms.summernote>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="keterangan_field" required>Keterangan</x-atoms.form-label>
                <x-atoms.summernote id="keterangan_field" name="keterangan" placeholder="Masukkan Keterangan">
                    {!! $data->asesmen_penilaian->keterangan !!}
                </x-atoms.summernote>
            </div>
        </div>
        <div class="col-12">
            <div class="mb-3">
                <x-atoms.form-label for="status-rekomendasi_field" required>Status
                    Rekomendasi</x-atoms.form-label>
                <x-mollecules.radio-group name="status_rekomendasi" id="status-rekomendasi_field" :value="$data->asesmen_penilaian->status_rekomendasi"
                    :lists="[
                        'DIREKOMENDASIKAN' => 'Direkomendasikan',
                        'TIDAK_DIREKOMENDASIKAN' => 'Tidak Direkomendasikan',
                    ]" />
            </div>
        </div>
    </div>
    <x-slot:footer>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </x-slot:footer>
</x-mollecules.modal>
