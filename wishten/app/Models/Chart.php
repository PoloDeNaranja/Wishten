<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Esta clase sirve para crear objetos que contienen los parámetros necesarios para crear gráficos usando la librería Chart.js
 */

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
