@extends('layouts.app')
@section('title', 'Verifikasi Persyaratan Catin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card zoom-in">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-10 col-sm-12 mb-3">
                            <h4 class="card-title">Data Calon Pengantin</h4>
                            <p>
                                Berikut adalah data pengantin yang telah mengajukan dispensasi pernikahan.
                            </p>
                        </div>
                        <div class="col-md-2 col-sm-12 mb-3 text-end">
                            <a href="{{ route('catin.verifikasi-catin.show', $catin->dispensasi->id) }}"
                                class="btn btn-outline-primary">Kembali</a>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <div class="p-1 mx-0 row">
                                <div class="col-12">
                                    <img src="{{ asset($catin->pas_foto) }}" alt="Foto Pengantin Pria"
                                        class="img-fluid mx-auto d-block" style="max-width: 100%; max-height: 300px;" />
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">NIK</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->nik }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Nama Pengantin</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->nama_lengkap }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Tempat, Tgl. Lahir</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->tempat_lahir }},
                                        {{ formatDateIndonesia($catin->tanggal_lahir) }} (
                                        {{ countAge($catin->tanggal_lahir) }} Tahun )
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Nomor HP</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->nomor_hp }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Pekerjaan</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->pekerjaan }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Alamat</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->alamat }},
                                        {{ $catin->kelurahan->nama_kelurahan }},
                                        {{ $catin->kecamatan->nama_kecamatan }},
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Agama</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->agama->agama }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Pendidikan</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->pendidikan->pendidikan }}
                                    </p>
                                </div>
                            </div>
                            <hr class="my-2">
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Nama Ayah</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->nama_ayah }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Nama Ibu</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->nama_ibu }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-1 mx-0 row">
                                <div class="col-5 col-sm-4 col-md-3 col-lg-2">
                                    <label class="col-form-label">Nama Wali</label>
                                </div>
                                <div class="col-7 col-sm-8 col-md-9 col-lg-10 d-flex align-items-center">
                                    <p class="m-0">
                                        {{ $catin->nama_wali }}
                                    </p>
                                </div>
                            </div>
                            <hr class="my-2">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 mb-3">
                            <h4 class="card-title">Data Persyaratan Pengantin</h4>
                            <p>Data Pengantin
                                @if ($count_berkas !== $count_existing)
                                    Belum Lengkapi Semua, Silahkan hubungi pendaftar pengantin untuk melengkapi berkas
                                    persyaratan.
                                @else
                                    Sudah Lengkap, Silahkan cek berkas persyaratan dari pendaftar.
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th scope="col">No.</th>
                                    <th scope="col">Aksi</th>
                                    <th scope="col">Nama Persyaratan</th>
                                    <th scope="col">Wajib</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($semua_persyaratan as $persyaratan_catin)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            <button type="button" class="btn btn-light verif-btn"
                                                data-id="{{ $persyaratan_catin->cp_id }}"
                                                data-title="{{ $persyaratan_catin->ref_nama_persyaratan }}"
                                                data-active="{{ ($catin->dispensasi->status_persetujuan == 'PROPOSED' && $persyaratan_catin->cp_status !== null && $persyaratan_catin->cp_status !== 'APPROVED') ? 'true' : 'false' }}"
                                                @if ($persyaratan_catin->cp_status == 'APPROVED') disabled @endif>
                                                <i class="fas fa-pen fs-2"></i>
                                            </button>
                                        </td>
                                        
                                        
                                        <td>{{ $persyaratan_catin->ref_nama_persyaratan }}</td>
                                        <td>
                                            @if ($persyaratan_catin->ref_is_wajib)
                                                <span class="badge bg-primary">Wajib</span>
                                            @else
                                                <span class="badge bg-light text-dark">Opsional</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if ($persyaratan_catin->cp_status == 'SUBMITTED')
                                                <span class="badge bg-warning">Menunggu Persetujuan</span>
                                            @elseif ($persyaratan_catin->cp_status == 'APPROVED')
                                                <span class="badge bg-success">Sesuai</span>
                                            @elseif ($persyaratan_catin->cp_status == 'REJECTED')
                                                <span class="badge bg-danger">Tidak Sesuai</span>
                                            @else
                                                <span class="badge bg-light text-dark">Belum Upload</span>
                                            @endif
                                        </td>
                                        <td>{{ $persyaratan_catin->cp_keterangan ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="verifikasiModal" tabindex="-1" aria-labelledby="verifikasiModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verifikasiModalLabel">Verifikasi Berkas <span id="title_modal"></span>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="verifikasiForm" custom-action>
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="persyaratan" class="form-label">Persyaratan</label>
                            <embed id="persyaratan_pdf" src="" type="application/pdf" width="100%"
                                height="300px" style="display:none">
                            <img id="persyaratan_img" src="" alt="Persyaratan Catin" style="display:none"
                                width="100%">
                        </div>
                        <div class="mb-3">
                            <label for="status_verifikasi" class="form-label">Status Verifikasi</label>
                            <select class="form-control" id="status_verifikasi" name="status_verifikasi">
                                <option value="">Pilih Status Verifikasi</option>
                                <option value="SUBMITTED">Menunggu Persetujuan</option>
                                <option value="APPROVED">Sesuai</option>
                                <option value="REJECTED">Tidak Sesuai</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="nama_lengkap" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="catin_keterangan" name="catin_keterangan" rows="3"></textarea>
                        </div>
                        <input type="hidden" id="persyaratan_catin_id" name="persyaratan_catin_id">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Verifikasi Berkas</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('.verif-btn').click(function() {
                const catinId = $(this).data('id');
                $.ajax({
                    url: `/catin/verifikasi-catin/${catinId}/edit`,
                    method: 'GET',
                    success: function(response) {
                        let fileExtension = getFileExtension(response.file_path.preview);
                        if (fileExtension == 'pdf') {
                            $('#persyaratan_pdf').attr('src', response.file_path.preview);
                            $('#persyaratan_img').hide();
                            $('#persyaratan_pdf').show();
                        } else {
                            $('#persyaratan_img').attr('src', response.file_path.preview);
                            $('#persyaratan_pdf').hide();
                            $('#persyaratan_img').show();
                        }
                        $('#persyaratan_catin_id').val(catinId);
                        $('#title_modal').text(response.persyaratan.nama_persyaratan);
                        $('#persyaratan').attr('src', response.file_path.preview);
                        $('#catin_keterangan').val(response.keterangan);
                        $('#status_verifikasi').val(response.status);
                        $('#verifikasiModal').modal('show');
                    }
                });
            });

            $('#verifikasiForm').submit(function(e) {
                e.preventDefault();

                const catinId = $('#persyaratan_catin_id').val();
                const data = $(this).serialize();

                $.ajax({
                    url: `/catin/verifikasi-catin/${catinId}`,
                    method: 'PUT',
                    data: data,
                    success: function(response) {
                        $('#verifikasiModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil!',
                            text: response.message,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.reload();
                            }
                        });
                    }
                });
            });

            function getFileExtension(filePath) {
                return filePath.split('.').pop();
            }
        });
    </script>
@endpush

