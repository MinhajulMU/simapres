<?php

use Illuminate\Database\Seeder;
use App\Model\Mahasiswa;
use Faker\Factory as Faker;
class mahasiswaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    protected $fakultas = array('FMIPA','FBS','FIP','FIK','FIS','FH','FT','FE');
    public function randomFloat($min = 0, $max = 1) {
        return $min + mt_rand() / mt_getrandmax() * ($max - $min);
    }
     public function run()
    {
        //
        DB::table('mahasiswa')->truncate();
        $faker = Faker::create('id_ID');
        $i = 0;
        while ($i <100) {
            # code...
            $rand_index = array_rand($this->fakultas);
            Mahasiswa::create([
                'nama' => $faker->name,
                'nim' => rand(1000000000,8000000000),
                'fakultas' => $this->fakultas[$rand_index],
                'prestasi' => rand(20,150),
                'bahasa_asing' => rand(20,100),
                'karya_ilmiah' => rand(20,100),
                'ipk' => round($this->randomFloat(3,4),2),
                'indeks_sks' => round($this->randomFloat(18,24),2)
            ]);
            $i++;
        }
    }

}
