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
            $key->r_ipk = $key->l_ipk/(sqrt($temp_ipk));
            $key->r_prestasi = $key->l_prestasi/(sqrt($temp_prestasi));
            $key->r_karya_ilmiah = $key->l_karya_ilmiah/(sqrt($temp_karya_ilmiah));
            $key->r_bahasa_asing = $key->l_bahasa_asing/(sqrt($temp_bahasa_asing));
            $key->r_indeks_sks = $key->l_indeks_sks/(sqrt($temp_indeks_sks));
        }


        return $mahasiswa;        
    }

    public function get_terbobot()
    {
        # code...
        $mahasiswa = $this->get_normalized();
        $options = \App\Model\Setting::getAllKeyValue();
        $c1 = json_decode($options['c1']);
        $c2 = json_decode($options['c2']);
        $c3 = json_decode($options['c3']);
        $c4 = json_decode($options['c4']);
        $c5 = json_decode($options['c5']);
        foreach ($mahasiswa as $key) {
            # code...
            $key->v_ipk = $key->r_ipk*$c1->weight;
            $key->v_prestasi = $key->r_prestasi*$c2->weight;
            $key->v_karya_ilmiah = $key->r_karya_ilmiah*$c3->weight;
            $key->v_bahasa_asing = $key->r_bahasa_asing*$c4->weight;
            $key->v_indeks_sks = $key->r_indeks_sks*$c5->weight;
        }

        return $mahasiswa;
    }
    public function get_ideal()
    {
        # code...
        $options = \App\Model\Setting::getAllKeyValue();
        $c1 = json_decode($options['c1']);
        $c2 = json_decode($options['c2']);
        $c3 = json_decode($options['c3']);
        $c4 = json_decode($options['c4']);
        $c5 = json_decode($options['c5']);
        $mahasiswa = $this->get_terbobot();
        $temp_ipk = [];
        $temp_prestasi = [];
        $temp_karya_ilmiah = [];
        $temp_bahasa_asing = [];
        $temp_indeks_sks = [];
        foreach ($mahasiswa as $key) {
            # code...
            $temp_ipk[] = $key->v_ipk;
            $temp_prestasi[] = $key->v_prestasi;
            $temp_karya_ilmiah[] = $key->v_karya_ilmiah;
            $temp_bahasa_asing[] = $key->v_bahasa_asing;
            $temp_indeks_sks[] = $key->v_indeks_sks;
        }
        
        $solusi = array(
            'c1' => array('positif' => (!$c1->is_cost) ?  max($temp_prestasi) :  min($temp_prestasi),'negatif' => ($c1->is_cost) ?  max($temp_prestasi) :  min($temp_prestasi)),
            'c2' => array('positif' => (!$c2->is_cost) ?  max($temp_karya_ilmiah) :  min($temp_karya_ilmiah),'negatif' => ($c2->is_cost) ?  max($temp_karya_ilmiah) :  min($temp_karya_ilmiah)),
            'c3' => array('positif' => (!$c3->is_cost) ?  max($temp_bahasa_asing) :  min($temp_bahasa_asing),'negatif' => ($c3->is_cost) ?  max($temp_bahasa_asing) :  min($temp_bahasa_asing)),
            'c4' => array('positif' => (!$c4->is_cost) ?  max($temp_ipk) :  min($temp_ipk),'negatif' => ($c4->is_cost) ?  max($temp_ipk) :  min($temp_ipk)),
            'c5' => array('positif' => (!$c5->is_cost) ?  max($temp_indeks_sks) :  min($temp_indeks_sks),'negatif' => ($c5->is_cost) ?  max($temp_indeks_sks) :  min($temp_indeks_sks)),
        );

        return $solusi;
    }
    public function get_positif_distance()
    {
        # code...
        $mahasiswa = $this->get_terbobot();
        $solusi_ideal = $this->get_ideal();
        foreach ($mahasiswa as $key) {
            # code...
            $key->a_prestasi = pow(($key->v_prestasi - $solusi_ideal['c1']['positif']),2);
            $key->a_karya_ilmiah = pow(($key->v_karya_ilmiah - $solusi_ideal['c2']['positif']),2);
            $key->a_bahasa_asing = pow(($key->v_bahasa_asing - $solusi_ideal['c3']['positif']),2);
            $key->a_ipk = pow(($key->v_ipk - $solusi_ideal['c4']['positif']),2);
            $key->a_indeks_sks = pow(($key->v_indeks_sks - $solusi_ideal['c5']['positif']),2);
            $key->a_total = sqrt($key->a_prestasi+$key->a_karya_ilmiah+$key->a_bahasa_asing+$key->a_ipk+$key->a_indeks_sks);
        }
        return $mahasiswa;
    }
    public function get_negatif_distance()
    {
        # code...
        $mahasiswa = $this->get_positif_distance();
        $solusi_ideal = $this->get_ideal();
        foreach ($mahasiswa as $key) {
            # code...
            $key->b_prestasi = pow(($key->v_prestasi - $solusi_ideal['c1']['negatif']),2);
            $key->b_karya_ilmiah = pow(($key->v_karya_ilmiah - $solusi_ideal['c2']['negatif']),2);
            $key->b_bahasa_asing = pow(($key->v_bahasa_asing - $solusi_ideal['c3']['negatif']),2);
            $key->b_ipk = pow(($key->v_ipk - $solusi_ideal['c4']['negatif']),2);
            $key->b_indeks_sks = pow(($key->v_indeks_sks - $solusi_ideal['c5']['negatif']),2);
            $key->b_total = sqrt($key->b_prestasi+$key->b_karya_ilmiah+$key->b_bahasa_asing+$key->b_ipk+$key->b_indeks_sks);
        }
        return $mahasiswa;
    }
    public function get_nilai_preferensi()
    {
        # code...
        $mahasiswa = $this->get_negatif_distance();
        foreach ($mahasiswa as $key) {
            # code...
            $key->nilai_preferensi = $key->b_total/($key->a_total + $key->b_total);
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
    public function matrix_keputusan_terbobot()
    {
        # code...
        $mahasiswa = $this->get_terbobot();
        return Datatables::of($mahasiswa)
                ->setRowId(function(Mahasiswa $mahasiswa){
                    return $mahasiswa->id;
                })->make(true);
    }
    
    public function solusi_ideal()
    {
        # code...
        $data['solusi'] = $this->get_ideal();
        return view('admin.topsis.matrix_solusi_ideal',$data);
    }
    public function jarak_solusi_positif()
    {
        # code...
        $mahasiswa = $this->get_positif_distance();
        return Datatables::of($mahasiswa)
                ->setRowId(function(Mahasiswa $mahasiswa){
                    return $mahasiswa->id;
                })->make(true);
    }
    public function jarak_solusi_negatif()
    {
        # code...
        $mahasiswa = $this->get_negatif_distance();
        return Datatables::of($mahasiswa)
                ->setRowId(function(Mahasiswa $mahasiswa){
                    return $mahasiswa->id;
                })->make(true);
    }
    public function nilai_preferensi()
    {
        # code...
        $mahasiswa = $this->get_nilai_preferensi();
        return Datatables::of($mahasiswa)
                ->setRowId(function(Mahasiswa $mahasiswa){
                    return $mahasiswa->id;
                })->make(true);
    }

}
