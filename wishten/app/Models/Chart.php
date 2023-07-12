<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chart extends Model
{
    use HasFactory;

    public $id, $labels, $dataset, $colors;

    public function __construct($id, $labels, $dataset, $colors) {
        $this->id = $id;
        $this->labels = $labels;
        $this->dataset = $dataset;
        $this->colors = $colors;
    }
}
