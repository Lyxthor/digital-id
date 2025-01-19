<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Citizen;
use App\Models\User;
use App\Models\Userable;

class CitizenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $data =
    [
        [
            "nik" => "3201010101010001",
            "name" => "Ahmad Syahputra",
            "birth_place" => "Jakarta",
            "birth_date" => "1995-08-12",
            "address" => "Jl. Melati No. 12",
            "village" => "Kelurahan Melati",
            "regency" => "Jakarta Selatan",
            "district" => "Setiabudi",
            "province" => "DKI Jakarta",
            "religion" => "Islam",
            "education" => "Bachelor's Degree",
            "job" => "Engineer",
            "gender" => "m",
            "blood_type" => "O",
            "marriage_status" => "kawin",
        ],
        [
            "nik" => "3201010101010002",
            "name" => "Siti Aminah",
            "birth_place" => "Bandung",
            "birth_date" => "1993-04-15",
            "address" => "Jl. Anggrek No. 10",
            "village" => "Kelurahan Anggrek",
            "regency" => "Bandung",
            "district" => "Sumur Bandung",
            "province" => "Jawa Barat",
            "religion" => "Islam",
            "education" => "Master's Degree",
            "job" => "Teacher",
            "gender" => "f",
            "blood_type" => "A",
            "marriage_status" => "belum kawin",
        ],
        [
            "nik" => "3201010101010003",
            "name" => "Budi Santoso",
            "birth_place" => "Surabaya",
            "birth_date" => "1990-12-01",
            "address" => "Jl. Mawar No. 20",
            "village" => "Kelurahan Mawar",
            "regency" => "Surabaya",
            "district" => "Genteng",
            "province" => "Jawa Timur",
            "religion" => "Kristen",
            "education" => "High School",
            "job" => "Driver",
            "gender" => "m",
            "blood_type" => "B",
            "marriage_status" => "kawin",
        ],
        [
            "nik" => "3201010101010004",
            "name" => "Ani Lestari",
            "birth_place" => "Yogyakarta",
            "birth_date" => "1988-05-10",
            "address" => "Jl. Kenanga No. 15",
            "village" => "Kelurahan Kenanga",
            "regency" => "Yogyakarta",
            "district" => "Gedongtengen",
            "province" => "DI Yogyakarta",
            "religion" => "Islam",
            "education" => "Bachelor's Degree",
            "job" => "Entrepreneur",
            "gender" => "f",
            "blood_type" => "O",
            "marriage_status" => "belum kawin",
        ],
        [
            "nik" => "3201010101010005",
            "name" => "Rudi Hartono",
            "birth_place" => "Medan",
            "birth_date" => "1996-09-17",
            "address" => "Jl. Cempaka No. 22",
            "village" => "Kelurahan Cempaka",
            "regency" => "Medan",
            "district" => "Medan Timur",
            "province" => "Sumatera Utara",
            "religion" => "Islam",
            "education" => "Diploma",
            "job" => "Technician",
            "gender" => "m",
            "blood_type" => "AB",
            "marriage_status" => "kawin",
        ],
        [
            "nik" => "3201010101010006",
            "name" => "Linda Kusuma",
            "birth_place" => "Semarang",
            "birth_date" => "1992-07-25",
            "address" => "Jl. Tulip No. 18",
            "village" => "Kelurahan Tulip",
            "regency" => "Semarang",
            "district" => "Semarang Tengah",
            "province" => "Jawa Tengah",
            "religion" => "Hindu",
            "education" => "Bachelor's Degree",
            "job" => "Accountant",
            "gender" => "f",
            "blood_type" => "B",
            "marriage_status" => "kawin",
        ],
        [
            "nik" => "3201010101010007",
            "name" => "Fajar Pratama",
            "birth_place" => "Palembang",
            "birth_date" => "1997-11-30",
            "address" => "Jl. Sakura No. 9",
            "village" => "Kelurahan Sakura",
            "regency" => "Palembang",
            "district" => "Bukit Kecil",
            "province" => "Sumatera Selatan",
            "religion" => "Islam",
            "education" => "Bachelor's Degree",
            "job" => "Software Developer",
            "gender" => "m",
            "blood_type" => "O",
            "marriage_status" => "belum kawin",
        ],
        [
            "nik" => "3201010101010008",
            "name" => "Sari Widya",
            "birth_place" => "Makassar",
            "birth_date" => "1994-02-14",
            "address" => "Jl. Dahlia No. 17",
            "village" => "Kelurahan Dahlia",
            "regency" => "Makassar",
            "district" => "Panakkukang",
            "province" => "Sulawesi Selatan",
            "religion" => "Islam",
            "education" => "High School",
            "job" => "Cashier",
            "gender" => "f",
            "blood_type" => "A",
            "marriage_status" => "kawin",
        ],
        [
            "nik" => "3201010101010009",
            "name" => "Aditya Saputra",
            "birth_place" => "Balikpapan",
            "birth_date" => "1991-03-05",
            "address" => "Jl. Melur No. 5",
            "village" => "Kelurahan Melur",
            "regency" => "Balikpapan",
            "district" => "Balikpapan Selatan",
            "province" => "Kalimantan Timur",
            "religion" => "Buddha",
            "education" => "Bachelor's Degree",
            "job" => "Architect",
            "gender" => "m",
            "blood_type" => "AB",
            "marriage_status" => "kawin",
        ],
        [
            "nik" => "3201010101010010",
            "name" => "Nina Kartika",
            "birth_place" => "Denpasar",
            "birth_date" => "1998-06-20",
            "address" => "Jl. Flamboyan No. 30",
            "village" => "Kelurahan Flamboyan",
            "regency" => "Denpasar",
            "district" => "Denpasar Barat",
            "province" => "Bali",
            "religion" => "Hindu",
            "education" => "Diploma",
            "job" => "Tour Guide",
            "gender" => "f",
            "blood_type" => "O",
            "marriage_status" => "belum kawin",
        ],
    ];



    public function run(): void
    {
        foreach($this->data as $d)
        {
            $user = $this->generateUser($d);
            $d["pp_img_path"] = "no_profile.enc";
            $citizen = Citizen::create($d);
            $user["userable_type"] = "citizen";
            $user["userable_id"] = $citizen->id;
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
