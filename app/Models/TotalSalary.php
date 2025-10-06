<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalSalary extends Model
{
    use HasFactory;

    protected $table = "total_salary";

    public $fillable = ['total_gapok', 'total_lembur', 'total_meal_transport', 'total_bpjstk', 'total_bpjskes', 'total_pph21', 'total_pot_lain', 'total_bruto', 'total_potongan', 'total_thp'];
}
