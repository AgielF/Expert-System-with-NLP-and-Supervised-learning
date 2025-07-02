<?php

namespace App\Http\Controllers;

abstract class Controller
{
    public function fuzzyUsia($usia)
    {
        if ($usia < 30) return 0.2;
        if ($usia < 50) return 0.5;
        return 1;
    }

    public function fuzzySuhu($suhu)
    {
        if ($suhu >= 36 && $suhu <= 37.5) return 0;
        if ($suhu < 36) return 0.5;
        return 1;
    }

    public function fuzzyTekanan($td)
    {
        if ($td >= 90 && $td <= 120) return 0;
        if ($td < 90 || $td > 140) return 1;
        return 0.5;
    }

    public function fuzzyAsamUrat($au)
    {
        if ($au <= 7) return 0;
        if ($au <= 10) return 0.5;
        return 1;
    }

    public function fuzzyUrine($u)
    {
        if ($u <= 300) return 0.2;
        if ($u <= 500) return 0.5;
        return 1;
    }

    public function fuzzyAirPutih($liters)
    {
        if ($liters >= 8) return 0;
        if ($liters >= 5) return 0.5;
        return 1;
    }
}
