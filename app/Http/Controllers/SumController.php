<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SumController extends Controller
{
    public function sum($datas){
        $sum = 0;
        foreach ($datas as $number) {
            $sum += $number['amount'];
        }
        return $sum;
    }
}
