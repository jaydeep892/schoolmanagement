<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ParentModel;

class ParentSeeder extends Seeder
{
    public function run(): void
    {
        $parents = [
            [
                'name' => 'Parent1',
                'email' => 'Parent1@testmail.com',
            ],
            [
                'name' => 'Parent2',
                'email' => 'Parent2@testmail.com',
            ],
        ];
        ParentModel::insert($parents);
    }
}
