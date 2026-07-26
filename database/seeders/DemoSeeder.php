<?php

namespace Database\Seeders;

use App\Models\SavingsGoal;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DemoSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'sarah@dambill.test'],
            ['name' => 'Sarah', 'password' => bcrypt('password')]
        );

        $transactions = [
            ['Apple Store', 'Electronics', -1299.00, 'completed', '2023-10-24'],
            ['Monthly Salary', 'Income', 6400.00, 'completed', '2023-10-20'],
            ['Whole Foods Market', 'Groceries', -142.50, 'completed', '2023-10-19'],
            ['Amazon Prime Video', 'Entertainment', -14.99, 'completed', '2023-10-24'],
            ['The Green Bistro', 'Dining', -42.10, 'completed', '2023-10-23'],
            ['Power Grid Co.', 'Utilities', -115.45, 'pending', '2023-10-21'],
            ['Uber Trip', 'Transport', -22.50, 'completed', '2023-10-20'],
            ['Unknown Merchant', 'Flagged', -299.00, 'flagged', '2023-10-19'],
        ];

        foreach ($transactions as $t) {
            Transaction::create([
                'user_id' => $user->id,
                'description' => $t[0],
                'category' => $t[1],
                'amount' => $t[2],
                'status' => $t[3],
                'transaction_date' => $t[4],
            ]);
        }

        $goals = [
            ['Rumah Baru', 'home', 150000000, 85000000, '2026-06-01'],
            ['Dana Darurat', 'shield', 50000000, 45000000, '2024-12-01'],
            ['Liburan Jepang', 'plane', 25000000, 15200000, '2025-04-01'],
        ];

        foreach ($goals as $g) {
            SavingsGoal::create([
                'user_id' => $user->id,
                'name' => $g[0],
                'icon' => $g[1],
                'target_amount' => $g[2],
                'current_amount' => $g[3],
                'target_date' => $g[4],
            ]);
        }
    }
}