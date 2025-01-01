<?php

namespace lahmidielidrissi\DebugHelper\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use GuzzleHttp\Client;

class SuggestionController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('AIMLA_API_KEY');
    }

    public function getSuggestion(Request $request)
    {        
        $errorMessage = $request->input('error');
        $errorMessage = str_replace('"' ,' ', $errorMessage);      
        $errorMessage = str_replace("'" ," ", $errorMessage);      

        $client = new Client();
        $response = $client->post('https://api.aimlapi.com/chat/completions', [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->apiKey,
                'Content-Type'  => 'application/json',
            ],
            'json' => [
                'model' => 'meta-llama/Llama-3.3-70B-Instruct-Turbo',
                'messages' => [ "role" => "user", "Suggest a fix for this Laravel error: {$errorMessage}"],
            ],
        ]);

        $result = json_decode($response->getBody(), true);
        return $result['choices'][0]['text'] ?? 'No suggestions available.';

        return response()->json(['suggestion' => 'suggestion test']);
    }
}
