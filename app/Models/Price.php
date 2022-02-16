<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
{
    use HasFactory;
    
    protected $fillable = ['H1','H2','H3','H4','H5','H6','H7','H8','H9','H10','H11','M1','M2','M3','M4','M5','M6','M7','M8','M9','M10','M11','S1','S2','S3','S4','S5','S6','S7','S8','S9','S10','S11'];
}
