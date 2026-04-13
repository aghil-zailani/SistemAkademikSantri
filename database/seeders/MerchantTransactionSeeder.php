<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $petugas = \App\Models\User::whereIn('role', ['admin', 'staff', 'teacher'])->first();
        
        // Ensure students exist
        $students = \App\Models\Student::with('user')->take(10)->get();
        if ($students->isEmpty()) {
            $studentUsers = \App\Models\User::where('role', 'student')->get();
            foreach ($studentUsers as $index => $user) {
                \App\Models\Student::create([
                    'user_id' => $user->id,
                    'nama_lengkap' => $user->name,
                    'nisn' => '1000' . $index,
                    'nis' => 'NIS0' . $index,
                ]);
            }
            $students = \App\Models\Student::with('user')->take(10)->get();
        }

        if ($petugas && $students->count() > 0) {
            foreach ($students as $student) {
                // Buat 15 transaksi per siswa untuk melihat efek pagination
                for ($i = 0; $i < 15; $i++) {
                    \App\Models\MerchantTransaction::create([
                        'petugas_id' => $petugas->id,
                        'student_id' => $student->id,
                        'keterangan' => 'shoping',
                        'jumlah' => rand(1, 20) * 1000,
                        'created_at' => now()->subDays(rand(0, 30))->subHours(rand(0, 24)),
                    ]);
                }
            }
        }
    }
}
