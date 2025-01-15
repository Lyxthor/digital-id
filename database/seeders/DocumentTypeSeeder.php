<?php

namespace Database\Seeders;

use App\Models\DocumentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DocumentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    private $data =
    [
        [
            "name"=>"KTP",
            "category"=>"official",
            "ownership_count"=>"mono",
            "membership_count"=>"mono",
            "member_ownership"=>"main"
        ],
        [
            "name"=>"Akta Kelahiran",
            "category"=>"official",
            "ownership_count"=>"mono",
            "membership_count"=>"multi",
            "member_ownership"=>"main"
        ],
        [
            "name"=>"Kartu Keluarga",
            "category"=>"official",
            "ownership_count"=>"mono",
            "membership_count"=>"multi",
            "member_ownership"=>"all"
        ],
        [
            "name"=>"Surat Cerai",
            "category"=>"official",
            "ownership_count"=>"multi",
            "membership_count"=>"multi",
            "member_ownership"=>"all"
        ]
    ];
    public function run(): void
    {
        foreach($this->data as $d)
        {
            DocumentType::create($d);
        }

    }
}
