<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Mahasiswa;
use Yajra\Datatables\Datatables;

class analisaTopsis extends Controller
{
    //
    
    public function get_linguistik()
    {
        # code...
        $mahasiswa = \App\Model\Mahasiswa::all();
        //Prestasi
        foreach ($mahasiswa as $key) {
            # code...
            if (($key->prestasi > 0) and ($key->prestasi <= 20)) {
                # code...
                $key->l_prestasi = 0;
            }elseif (($key->prestasi > 20) and ($key->prestasi <= 40)) {
                # code...
                $key->l_prestasi = 0.2;
            }elseif (($key->prestasi > 40) and ($key->prestasi <= 80)) {
                # code...
                $key->l_prestasi = 0.4;
            }elseif (($key->prestasi > 80) and ($key->prestasi <= 100)) {
                # code...
                $key->l_prestasi = 0.6;
            }elseif (($key->prestasi > 100) and ($key->prestasi <= 120)) {
                # code...
                $key->l_prestasi = 0.8;
            }elseif ($key->prestasi > 120) {
                # code...
                $key->l_prestasi = 1;
            }
        }

        //karya tulis ilmiah
        foreach ($mahasiswa as $key) {
            # code...
            if (($key->karya_ilmiah > 0) and ($key->karya_ilmiah <= 40)) {
                # code...
                $key->l_karya_ilmiah = 0.2;
            }elseif (($key->karya_ilmiah > 40) and ($key->karya_ilmiah <= 70)) {
                # code...
                $key->l_karya_ilmiah = 0.5;
            }elseif (($key->karya_ilmiah > 70) and ($key->karya_ilmiah <= 85)) {
                # code...
                $key->l_karya_ilmiah = 0.75;
            }elseif (($key->karya_ilmiah > 85) and ($key->karya_ilmiah <= 100)) {
                # code...
                $key->l_karya_ilmiah = 1;
            }
        }
        //bahasa asing
        foreach ($mahasiswa as $key) {
            # code...
            if (($key->bahasa_asing > 0) and ($key->bahasa_asing <= 30)) {
                # code...
                $key->l_bahasa_asing = 0.2;
            }elseif (($key->bahasa_asing > 30) and ($key->bahasa_asing <= 60)) {
                # code...
                $key->l_bahasa_asing = 0.5;
            }elseif (($key->bahasa_asing > 60) and ($key->bahasa_asing <= 80)) {
                # code...
                $key->l_bahasa_asing = 0.75;
            }elseif (($key->bahasa_asing > 80) and ($key->bahasa_asing <= 100)) {
                # code...
                $key->l_bahasa_asing = 1;
            }
        }

        //IPK
        foreach ($mahasiswa as $key) {
            # code...
            if (($key->ipk > 3) and ($key->ipk <= 3.25)) {
                # code...
                $key->l_ipk = 0.2;
            }elseif (($key->ipk > 3.25) and ($key->ipk <= 3.5)) {
                # code...
                $key->l_ipk = 0.5;
            }elseif (($key->ipk > 3.5) and ($key->ipk <= 3.75)) {
                # code...
                $key->l_ipk = 0.75;
            }elseif (($key->ipk > 3.75) and ($key->ipk <= 4)) {
                # code...
                $key->l_ipk = 1;
            }
        }
        //indeks_sks
        foreach ($mahasiswa as $key) {
            # code...
            if (($key->indeks_sks > 0) and ($key->indeks_sks <= 18)) {
                # code...
                $key->l_indeks_sks = 0.2;
            }elseif (($key->indeks_sks > 18) and ($key->indeks_sks <= 19)) {
                # code...
                $key->l_indeks_sks = 0.5;
            }elseif (($key->indeks_sks > 19) and ($key->indeks_sks <= 21)) {
                # code...
                $key->l_indeks_sks = 0.75;
            }elseif (($key->indeks_sks > 21) and ($key->indeks_sks <= 24)) {
                # code...
                $key->l_indeks_sks = 1;
            }
        }

        return $mahasiswa->all();
    }
    public function get_normalized()
    {
        # code...
        $mahasiswa = $this->get_linguistik();
        $temp_ipk = 0;
        $temp_prestasi = 0;
        $temp_karya_ilmiah = 0;
        $temp_bahasa_asing = 0;
        $temp_indeks_sks = 0; 
        foreach ($mahasiswa as $key) {
            # code...
            $temp_ipk += $key->l_ipk*$key->l_ipk;
            $temp_prestasi += $key->l_prestasi*$key->l_prestasi;
            $temp_karya_ilmiah += $key->l_karya_ilmiah*$key->l_karya_ilmiah;
            $temp_bahasa_asing += $key->l_bahasa_asing*$key->l_bahasa_asing;
            $temp_indeks_sks += $key->l_indeks_sks*$key->l_indeks_sks;
        }
        foreach ($mahasiswa as $key) {
            # code...
            $key->r_ipk = $key->l_ipk*(sqrt($temp_ipk));
            $key->r_prestasi = $key->l_prestasi*(sqrt($temp_prestasi));
            $key->r_karya_ilmiah = $key->l_karya_ilmiah*(sqrt($temp_karya_ilmiah));
            $key->r_bahasa_asing = $key->l_bahasa_asing*(sqrt($temp_bahasa_asing));
            $key->r_indeks_sks = $key->l_indeks_sks*(sqrt($temp_indeks_sks));
        }


        return $mahasiswa;        
    }

    public function linguistik()
    {
        # code...
        $mahasiswa = $this->get_linguistik();
        return Datatables::of($mahasiswa)
                ->setRowId(function(Mahasiswa $mahasiswa){
                    return $mahasiswa->id;
                })->editColumn('l_prestasi',function($mahasiswa){
                    if ($mahasiswa->l_prestasi == 0 ) {
                        # code...
                        return "sangat rendah";
                    }elseif ($mahasiswa->l_prestasi == 0.2) {
                        # code...
                        return "Cukup Rendah";
                    }elseif ($mahasiswa->l_prestasi == 0.4) {
                        # code...
                        return "Rendah";
                    }elseif ($mahasiswa->l_prestasi == 0.6) {
                        # code...
                        return "Sedang";
                    }elseif ($mahasiswa->l_prestasi == 0.8) {
                        # code...
                        return "Tinggi";
                    }elseif ($mahasiswa->l_prestasi == 1) {
                        # code...
                        return "Sangat Tinggi";
                    }
                })->editColumn('l_karya_ilmiah',function($mahasiswa){
                    if ($mahasiswa->l_karya_ilmiah == 0.2 ) {
                        # code...
                        return "Rendah";
                    }elseif ($mahasiswa->l_karya_ilmiah == 0.5) {
                        # code...
                        return "Cukup";
                    }elseif ($mahasiswa->l_karya_ilmiah == 0.75) {
                        # code...
                        return "Tinggi";
                    }elseif ($mahasiswa->l_karya_ilmiah == 1) {
                        # code...
                        return "Sangat Tinggi";
                    }
                })->editColumn('l_bahasa_asing',function($mahasiswa){
                    if ($mahasiswa->l_bahasa_asing == 0.2 ) {
                        # code...
                        return "Rendah";
                    }elseif ($mahasiswa->l_bahasa_asing == 0.5) {
                        # code...
                        return "Cukup";
                    }elseif ($mahasiswa->l_bahasa_asing == 0.75) {
                        # code...
                        return "Tinggi";
                    }elseif ($mahasiswa->l_bahasa_asing == 1) {
                        # code...
                        return "Sangat Tinggi";
                    }
                })->editColumn('l_ipk',function($mahasiswa){
                    if ($mahasiswa->l_ipk == 0.2 ) {
                        # code...
                        return "Rendah";
                    }elseif ($mahasiswa->l_ipk == 0.5) {
                        # code...
                        return "Cukup";
                    }elseif ($mahasiswa->l_ipk == 0.75) {
                        # code...
                        return "Tinggi";
                    }elseif ($mahasiswa->l_ipk == 1) {
                        # code...
                        return "Sangat Tinggi";
                    }
                })->editColumn('l_indeks_sks',function($mahasiswa){
                    if ($mahasiswa->l_indeks_sks == 0.2 ) {
                        # code...
                        return "Rendah";
                    }elseif ($mahasiswa->l_indeks_sks == 0.5) {
                        # code...
                        return "Cukup";
                    }elseif ($mahasiswa->l_indeks_sks == 0.75) {
                        # code...
                        return "Tinggi";
                    }elseif ($mahasiswa->l_indeks_sks == 1) {
                        # code...
                        return "Sangat Tinggi";
                    }
                })
                ->make(true);
         
    }
    public function matrix_keputusan()
    {
        # code...
        $mahasiswa = $this->get_linguistik();
        return Datatables::of($mahasiswa)
                ->setRowId(function(Mahasiswa $mahasiswa){
                    return $mahasiswa->id;
                })->make(true);
    }
    public function matrix_keputusan_ternormalisasi()
    {
        # code...
        $mahasiswa = $this->get_normalized();
        return Datatables::of($mahasiswa)
                ->setRowId(function(Mahasiswa $mahasiswa){
                    return $mahasiswa->id;
                })->make(true);
    }

}
