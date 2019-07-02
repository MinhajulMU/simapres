@extends('layouts.admin')
@section('title')
    Jarak Solusi Positif | SIMAPRES
@endsection
@section('content')
<br>

<div class="row">
    <div class="col-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Jarak Solusi Positif</b></h4>
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
                    <th>Total</th>
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
                    ajax: '{!! route('admin.topsis.jarak_solusi_positif') !!}',
                    order:[0,'desc'],
                    columns:[
                        {data:'id', name: 'id'},
                        {data:'nama', name: 'nama'},
                        {data:'a_prestasi',name:'a_prestasi'},
                        {data:'a_karya_ilmiah',name:'a_karya_ilmiah'},
                        {data:'a_bahasa_asing',name:'a_bahasa_asing'},
                        {data:'a_ipk',name:'a_ipk'},
                        {data:'a_indeks_sks',name:'a_indeks_sks'},
                        {data:'a_total',name:'a_total'}                        
                    ]
                });
            } );

        </script>
        @include("admin.script.form-modal-ajax")
@endpush