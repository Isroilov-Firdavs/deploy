<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class FootballController extends Controller
{
    private $apiToken = '721f092114ae4acdad450a43e9996cf4'; // O'zingizning tokeningizni shu yerga qo'ying

    public function index()
    {
        // Dastlabki sahifa, maydonlar (filter uchun)
        return view('football.index');
    }

    public function getMatches(Request $request)
    {
        // Filter parametrlari olish
        $competition = $request->competition ?? null;
        $status = $request->status ?? null;

        $query = [];

        if ($competition) {
            $query['competitions'] = $competition;  // masalan: PL, CL, SA va h.k.
        }
        if ($status) {
            $query['status'] = strtoupper($status); // SCHEDULED, FINISHED va hokazo
        }

        $response = Http::withHeaders([
            'X-Auth-Token' => $this->apiToken,
        ])->get('https://api.football-data.org/v4/matches', $query);

        if ($response->successful()) {
            return response()->json($response->json());
        } else {
            return response()->json(['error' => 'API bilan bog\'lanishda xatolik yuz berdi'], 500);
        }
    }
}
