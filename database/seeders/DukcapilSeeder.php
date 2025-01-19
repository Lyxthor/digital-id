<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dukcapil;

class DukcapilSeeder extends Seeder
{
    private $data =
    [
        [
            "nik" => "3202010202020001",
            "name" => "Dimas Angkasa",
            "birth_place" => "Malang",
            "birth_date" => "1990-07-21",
            "current_address" => "Jl. Ijen No. 25, Malang",
            "address" => "Jl. Cemara No. 12",
            "village" => "Kelurahan Cemara",
            "regency" => "Malang",
            "district" => "Klojen",
            "province" => "Jawa Timur",
            "religion" => "Islam",
            "education" => "Bachelor's Degree",
            "job" => "Lecturer",
            "gender" => "m",
            "blood_type" => "A",
            "marriage_status" => "kawin",
            "active_status" => true,
            "start_date" => "2020-01-15",
            "end_date" => null,
            "province_authority" => "Jawa Timur",
        ],
        [
            "nik" => "3202010202020002",
            "name" => "Ratna Sari Dewi",
            "birth_place" => "Pontianak",
            "birth_date" => "1993-05-30",
            "current_address" => "Jl. Tanjungpura No. 14, Pontianak",
            "address" => "Jl. Merak No. 20",
            "village" => "Kelurahan Merak",
            "regency" => "Pontianak",
            "district" => "Pontianak Kota",
            "province" => "Kalimantan Barat",
            "religion" => "Kristen",
            "education" => "Master's Degree",
            "job" => "Project Manager",
            "gender" => "f",
            "blood_type" => "B",
            "marriage_status" => "belum kawin",
            "active_status" => true,
            "start_date" => "2019-11-01",
            "end_date" => null,
            "province_authority" => "Kalimantan Barat",
        ],
        [
            "nik" => "3202010202020003",
            "name" => "Agus Wirawan",
            "birth_place" => "Banda Aceh",
            "birth_date" => "1985-02-14",
            "current_address" => "Jl. Teuku Umar No. 7, Banda Aceh",
            "address" => "Jl. Angsana No. 33",
            "village" => "Kelurahan Angsana",
            "regency" => "Banda Aceh",
            "district" => "Baiturrahman",
            "province" => "Aceh",
            "religion" => "Islam",
            "education" => "Diploma",
            "job" => "Chef",
            "gender" => "m",
            "blood_type" => "O",
            "marriage_status" => "kawin",
            "active_status" => false,
            "start_date" => "2015-06-01",
            "end_date" => "2023-06-01",
            "province_authority" => "Aceh",
        ],
        [
            "nik" => "3202010202020004",
            "name" => "Citra Permata",
            "birth_place" => "Manado",
            "birth_date" => "1997-08-10",
            "current_address" => "Jl. Boulevard No. 5, Manado",
            "address" => "Jl. Teratai No. 10",
            "village" => "Kelurahan Teratai",
            "regency" => "Manado",
            "district" => "Wenang",
            "province" => "Sulawesi Utara",
            "religion" => "Kristen",
            "education" => "Bachelor's Degree",
            "job" => "Graphic Designer",
            "gender" => "f",
            "blood_type" => "AB",
            "marriage_status" => "belum kawin",
            "active_status" => true,
            "start_date" => "2021-03-20",
            "end_date" => null,
            "province_authority" => "Sulawesi Utara",
        ],
        [
            "nik" => "3202010202020005",
            "name" => "Yoga Pranata",
            "birth_place" => "Pekanbaru",
            "birth_date" => "1991-11-05",
            "current_address" => "Jl. Soekarno Hatta No. 45, Pekanbaru",
            "address" => "Jl. Seruni No. 5",
            "village" => "Kelurahan Seruni",
            "regency" => "Pekanbaru",
            "district" => "Tampan",
            "province" => "Riau",
            "religion" => "Islam",
            "education" => "Master's Degree",
            "job" => "Civil Engineer",
            "gender" => "m",
            "blood_type" => "B",
            "marriage_status" => "kawin",
            "active_status" => false,
            "start_date" => "2018-04-10",
            "end_date" => "2022-12-31",
            "province_authority" => "Riau",
        ],
    ];
    public function run(): void
    {
        foreach($this->data as $d)
        {
            $user = $this->generateUser($d);
            $d["pp_img_path"] = "no_profile.enc";
            unset($d['current_address']);
            $dukcapil = Dukcapil::create($d);
            $user["userable_type"] = "dukcapil";
            $user["userable_id"] = $dukcapil->id;
            $user = User::create($user);
        }
    }
    private function generateUser($data)
    {
        // r
        $cleaned_name = strtolower($data["name"]);
        $cleaned_name = join(explode(" ", $cleaned_name));

        $username = $cleaned_name;
        $email = $username."@gmail.com";
        $mobile = $this->generateRandMobile();
        $password = bcrypt("1234567");
        return
        [
            "username"=>$username,
            "email"=>$email,
            "mobile"=>$mobile,
            "password"=>$password,
        ];
    }
    private function generateRandMobile()
    {
        $prefix = "085";
        $remaining_digits = "";
        for($i=0;$i<9;$i++)
        {
            $remaining_digits .= rand(0,9);
        }
        return $prefix.$remaining_digits;
    }
}
