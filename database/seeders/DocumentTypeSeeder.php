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
            "category"=>"protected",
            "multiability"=>"singular"
        ],
        [
            "name"=>"Akta Kelahiran",
            "category"=>"protected",
            "multiability"=>"singular"
        ],
        [
            "name"=>"Kartu Keluarga",
            "category"=>"protected",
            "multiability"=>"singular"
        ],
        [
            "name"=>"Surat Cerai",
            "category"=>"protected",
            "multiability"=>"multi"
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
