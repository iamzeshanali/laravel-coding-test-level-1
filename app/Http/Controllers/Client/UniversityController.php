<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function Termwind\renderUsing;

class UniversityController extends Controller
{
    public function getUniversities()
    {
        $url = "https://datausa.io/api/data?drilldowns=Nation&measures=Population";

        $client = new \GuzzleHttp\Client([
            'http_errors' => true,
            'allow_redirects' => false,
        ]);

        $response = $client->get($url);
        $decoded_response = json_decode($response->getBody(), true);
        return view('universities.uni', [
            'universities' => collect($decoded_response["data"])
        ]);
    }
}
