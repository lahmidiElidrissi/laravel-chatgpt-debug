<?php

use Illuminate\Support\Facades\Route;
use lahmidielidrissi\DebugHelper\Http\Controllers\SuggestionController;

Route::post('/debug-helper/suggestion', [SuggestionController::class, 'getSuggestion']);