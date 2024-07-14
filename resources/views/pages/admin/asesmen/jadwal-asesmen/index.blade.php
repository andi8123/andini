@extends('layouts.app')
@section('title', 'Jadwal Asesmen')

@section('content')
    <div class="app-container">
        <div class="py-4">
            <div class="d-flex flex-md-row flex-column gap-2 align-items-center w-100">
                <div class="search-box">
                    <label class="position-absolute " for="searchBox">
                        <i class="fal fa-search fs-3"></i>
                    </label>
                    <input type="text" data-table-id="jadwalasesmen-table" id="searchBox" data-action="search"
                        class="form-control form-control-solid w-250px ps-13" placeholder="Cari Jadwal" />
                </div>
                <div class="filter-box">
                    <x-atoms.select2 name="filter-status" id="filter-status" placeholder="Filter Status">
                        <option value="">Semua Status</option>
                        <option value="SUBMITTED">Menunggu Persetujuan</option>
                        <option value="REVISED">Revisi</option>
                        <option value="APPROVED">Disetujui</option>
                        <option value="REJECTED">Ditolak</option>

                    </x-atoms.select2>
                </div>
            </div>
        </div>

        <div class="card-body py-4">
            <div class="table-responsive">
                {{ $dataTable->table() }}
            </div>
        </div>

        @include('pages.admin.asesmen.jadwal-asesmen.partials.modals')


        @push('scripts')
            {{ $dataTable->scripts() }}
            <script>
                $(document).ready(function() {
                    $('#filter-status').on('change', function() {
                        const filter = $(this).val();
                        const url = new URL(window.location.href);
                        let params = new URLSearchParams(url.search);

                        if (filter) {
                            params.set('status', filter);
                        }

                        url.search = params.toString();
                        window.LaravelDataTables['jadwalasesmen-table'].ajax.url(url.toString()).load();
                    });
                })
            </script>
        @endpush
    @endsection
