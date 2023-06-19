<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Fund;
use App\Models\FundAlias;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fund::factory()
            ->has(FundAlias::factory()->count(3), 'aliases')
            ->has(Company::factory()->count(3), 'companies')
            ->count(10)
            ->create();
    }
}
