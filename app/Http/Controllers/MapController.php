<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;

class MapController extends Controller
{
    public function index(): View
    {
        $initialMarkers = [
            [
                'position' => [
                    'lat' => 18.269239,
                    'lng' => 143.11895
                ],
                'draggable' => true
            ],
            [
                'position' => [
                    'lat' => 25.20516,
                    'lng' => 149.550142
                ],
                'draggable' => false
            ],
            [
                'position' => [
                    'lat' => 54.841784,
                    'lng' => -25.857942
                ],
                'draggable' => true
            ]
        ];
        return view('map', compact('initialMarkers'));
    }
}
