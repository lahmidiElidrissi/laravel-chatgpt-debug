<?php

namespace lahmidielidrissi\DebugHelper\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class SuggestionController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function getSuggestion(Request $request)
    {        
        // $errorMessage = $request->input('error');

        // $client = new Client(env('OPENAI_API_KEY'));
        // $response = $client->chat()->create([
        //     'model' => 'gpt-4',
        //     'messages' => [
        //         ['role' => 'user', 'content' => "Laravel error: $errorMessage. How can I fix this?"],
        //     ],
        // ]);

        return response()->json(['suggestion' => 'suggestion test']);
    }
}
