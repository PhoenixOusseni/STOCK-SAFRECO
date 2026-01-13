<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('articles')->insert([
            [
                'code' => 'ART-00001',
                'designation' => 'Imprimante HP LaserJet M130 Pro',
                'reference' => 'Ar001',
                'prix_achat' => 110000.00,
                'prix_vente' => 150000.00,
                'date_entree' => '2024-01-01',
                'date_service' => '2024-01-02',
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'ART-00002',
                'designation' => 'Ordinateur Portable Dell Inspiron 15',
                'reference' => 'Ar002',
                'prix_achat' => 200000.00,
                'prix_vente' => 300000.00,
                'date_entree' => '2024-02-01',
                'date_service' => '2024-02-02',
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'code' => 'ART-00003',
                'designation' => 'Smartphone Samsung Galaxy S21',
                'reference' => 'Ar003',
                'prix_achat' => 250000.00,
                'prix_vente' => 400000.00,
                'date_entree' => '2024-03-01',
                'date_service' => '2024-03-02',
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'code' => 'ART-00004',
                'designation' => 'Tablette Apple iPad Air',
                'reference' => 'Ar004',
                'prix_achat' => 300000.00,
                'prix_vente' => 450000.00,
                'date_entree' => '2024-04-01',
                'date_service' => '2024-04-02',
                'stock' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
