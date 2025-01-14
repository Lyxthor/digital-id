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
            "current_address" => "Jl. Sudirman No. 45, Jakarta",
            "religion" => "Islam",
            "education" => "Bachelor's Degree",
            "job" => "Engineer",
            "gender" => "m",
            "blood_type" => "O",

        ],
        [
            "nik" => "3201010101010002",
            "name" => "Dewi Santika",
            "birth_place" => "Bandung",
            "birth_date" => "1998-05-15",
            "current_address" => "Jl. Ahmad Yani No. 12, Bandung",
            "religion" => "Islam",
            "education" => "High School",
            "job" => "Teacher",
            "gender" => "f",
            "blood_type" => "A",

        ],
        [
            "nik" => "3201010101010003",
            "name" => "Rian Saputra",
            "birth_place" => "Jakarta",
            "birth_date" => "2015-03-10",
            "current_address" => "Jl. Sudirman No. 45, Jakarta",
            "religion" => "Islam",
            "education" => "Elementary School",
            "job" => "Student",
            "gender" => "m",
            "blood_type" => "B",

        ],
        [
            "nik" => "3201010101010004",
            "name" => "Siti Aminah",
            "birth_place" => "Surabaya",
            "birth_date" => "2000-12-22",
            "current_address" => "Jl. Pemuda No. 20, Surabaya",
            "religion" => "Islam",
            "education" => "Bachelor's Degree",
            "job" => "Designer",
            "gender" => "f",
            "blood_type" => "AB",

        ],
        // Tambahkan data berikutnya...
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
