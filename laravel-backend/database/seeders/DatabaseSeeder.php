<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminSeeder::class,
            AdminUserSeeder::class,
            EconomicStatisticsSeeder::class,
            // コンテンツ系シード（一覧が空にならないように含める）
            NewsArticlesSeeder::class,
            SeminarSeeder::class,
            NewsV2Seeder::class,
            PublicationsSeeder::class,
            EconomicReportsSeeder::class,
            FinancialReportsSeeder::class,
            ServicesSeeder::class,
            PageContentsSeeder::class,
            CompletePagesSeeder::class,
            TermsPageJsonSeeder::class,
            EconomicIndicatorSeeder::class,
        ]);
    }
}
