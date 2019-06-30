<?php

namespace App\Http\Controllers;
use Yajra\Datatables\Datatables;
use Validator;
use \App\Helper\Alert;
use \App\Model\Mahasiswa;
use Illuminate\Http\Request;

class mahasiswaController extends Controller
{
    //
    public function index()
    {
        # code...

        return Datatables::of(Mahasiswa::all())
                ->setRowId(function(Mahasiswa $mahasiswa){
                    return $mahasiswa->id;
                })->addColumn('aksi','admin.mahasiswa.action-button')
                ->rawColumns(['aksi'])
                ->make(true);
         }

    public function delete(Request $request){
        $validator = Validator::make($request->all(),[
            "id"=> "required|numeric|exists:mahasiswa,id"
        ]);
        $response = ['ok'=>true];
        if($validator->fails()){
            $response['ok'] = false;
            $response['msg'] = "Id tidak valid";
        }else{
            Mahasiswa::find($request->input('id'))->delete();
            $response['msg'] = "berhasil menghapus data";
        }
        return response()->json($response, 200);
    }
    public function store(Request $request)
    {
        # code...
        $res = ['stored'=>true];
        $validator = Validator::make($request->all(),[
            "nama" => "required|min:3",
            'nim' => 'required|min:3',
            'fakultas' => 'required',
            'prestasi' => 'required|integer',
            'karya_ilmiah' => 'required|integer',
            'ipk' => 'required|numeric',
            'bahasa_asing' => 'required|numeric',
            'indeks_sks' => 'required|numeric'
        ]);
        if($validator->fails()){
            $res['msg'] = Alert::errorList($validator->errors());
            $res['stored'] = false;
        }else{
            $mahasiswa = new Mahasiswa();
            $mahasiswa->nama = $request->input("nama");
            $mahasiswa->nim = $request->input('nim');
            $mahasiswa->fakultas = $request->input('fakultas');
            $mahasiswa->prestasi = $request->input('prestasi');
            $mahasiswa->bahasa_asing = $request->input('bahasa_asing');
            $mahasiswa->karya_ilmiah = $request->input('karya_ilmiah');
            $mahasiswa->ipk = $request->input('ipk');
            $mahasiswa->indeks_sks = $request->input('indeks_sks');
            $mahasiswa->save();
            $res['msg'] = Alert::success("Berhasil Menambahkan Data");
        }

        return response()->json($res, 200);
    }
    public function update(Request $request)
    {
        # code...
        $validator = Validator::make($request->all(),[
            "name" => "required|min:3",
            'email' => 'required|email|max:60',
            'role' => 'required'
        ]);

        $response = ["stored"=>true];
        
        if($validator->fails()){
            $response['stored'] = false;
            $response['msg']    = Alert::errorList($validator->errors());
        }else{
            $user = User::find($request->input('id'));
            if($user){

                
                $user->name = $request->input("name");
                $user->email = $request->input('email');
                $user->save();
                $user->role()->sync($request->input('role'));
                $response['msg'] = Alert::success("Berhasil Memperbarui Data Portofolio");
            }else{
                $response['stored'] = false;
                $response['msg']    = Alert::errorList("Data tidak ditemukan");
            }
        }
        return response()->json($response, 200);
    }
}
