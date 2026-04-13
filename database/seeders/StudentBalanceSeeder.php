<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StudentBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $students = \App\Models\Student::with('user')->get();
        foreach ($students as $student) {
            $saldo = rand(10, 1000) * 1000;
            \App\Models\StudentBalance::create([
                'student_id' => $student->id,
                'saldo' => $saldo,
                'updated_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 24)),
            ]);

            // Create transactions
            $currentSaldo = $saldo;
            for ($i = 0; $i < 6; $i++) {
                $isCredit = rand(0, 1) === 1;
                $amount = rand(5, 50) * 1000;
                
                $credit = $isCredit ? $amount : 0;
                $debit = !$isCredit ? $amount : 0;
                
                $oldSaldo = $currentSaldo;
                $currentSaldo = $currentSaldo - $credit + $debit;

                \App\Models\StudentBalanceTransaction::create([
                    'student_id' => $student->id,
                    'note' => $isCredit ? 'Top Up ' . $student->nama_lengkap : 'Biaya ' . $student->nama_lengkap,
                    'open' => $oldSaldo,
                    'debit' => $debit,
                    'credit' => $credit,
                    'close' => $oldSaldo + $credit - $debit,
                    'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 24))
                ]);
            }
        }
    }
}
