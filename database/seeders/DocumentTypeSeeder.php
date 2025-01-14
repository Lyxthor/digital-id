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
            "multiability"=>"mono"
        ],
        [
            "name"=>"Akta Kelahiran",
            "category"=>"official",
            "multiability"=>"mono"
        ],
        [
            "name"=>"Kartu Keluarga",
            "category"=>"official",
            "multiability"=>"mono"
        ],
        [
            "name"=>"Surat Cerai",
            "category"=>"official",
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
