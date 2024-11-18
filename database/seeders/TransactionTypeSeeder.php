<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_types')->insert(
            [
                [
                    'name' => 'Transfer',
                    'code' => 'transfer',
                    'action' => 'dr',
                    'thumbnail' => 'transfer.png',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Internet',
                    'code' => 'internet',
                    'thumbnail' => 'store.png',
                    'action' => 'dr',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Top Up',
                    'code' => 'top_up',
                    'thumbnail' => 'topup.png',
                    'action' => 'cr',
                    'created_at' => now(),
                    'updated_at' => now()
                ],
                [
                    'name' => 'Receive',
                    'code' => 'receive',
                    'thumbnail' => 'recieve.png',
                    'action' => 'cr',
                    'created_at' => now(),
                    'updated_at' => now()
                ]
            ]
        );
    }
}
