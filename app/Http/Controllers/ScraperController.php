<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScraperController extends Controller
{
    public function index()
    {
        $jsonPath = base_path('matches.json');

        if (!File::exists($jsonPath)) {
            return response()->json(['error' => 'No data found'], 404);
        }

        $data = json_decode(File::get($jsonPath), true);
        return response()->json($data);
    }
}
