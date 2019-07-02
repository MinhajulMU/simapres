@extends('layouts.admin')
@section('title')
    Hasil Rekomendasi | SIMAPRES
@endsection
@section('content')
<br>

<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Hasil Rekomendasi</b></h4>
            <p class="text-muted font-14 m-b-30">
            
            </p>

            <table id="table-mahasiswa" class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Lengkap</th>
                    <th>Prestasi (C1)</th>
                    <th>Karya Ilmiah (C2)</th>
                    <th>Bahasa Asing (C3)</th>
                    <th>IPK (C4)</th>
                    <th>Indeks SKS (C5)</th>
                    <th>Nilai Preferensi</th>
                </tr>
                </thead>


                <tbody>
                </tbody>
            </table>
        </div>
    </div>
</div> <!-- end row -->
<!-- end row -->


@endsection
@push('scripts')
        <script type="text/javascript">
            
            $(document).ready(function() {
                $("#table-mahasiswa").DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('admin.topsis.nilai_preferensi') !!}',
                    order:[7,'desc'],
                    columns:[
                        {data:'id', name: 'id',orderable:false,visible:false},
                        {data:'nama', name: 'nama',orderable:false},
                        {data:'prestasi',name:'prestasi',orderable:false},
                        {data:'karya_ilmiah',name:'karya_ilmiah',orderable:false},
                        {data:'bahasa_asing',name:'bahasa_asing',orderable:false},
                        {data:'ipk',name:'a_ipk',orderable:false},
                        {data:'indeks_sks',name:'indeks_sks',orderable:false},
                        {data:'nilai_preferensi',name:'nilai_preferensi'}                        
                    ]
                });
            } );

        </script>
        @include("admin.script.form-modal-ajax")
@endpush