<?php

use App\Models\randNumbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

Route::get('/numbers/{id}', function (Request $request, $id) {
    try {
        $numberFromDB = randNumbs::where('id', $id)->take(1)->get();
        if (count($numberFromDB)) {
            $number = $numberFromDB[0];
            return response()->json([
                'id' => $number['id'],
                'number' => $number['number'],
            ], 200);
        }
        return response()->json([
            'message' => 'Requested number not found',
        ], 404);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Something went wrong. Contact API support',
        ], 500);
    }
})->middleware('basicAuth');

Route::post('/numbers', function (Request $request) {
    try {
        $newId = null;
        $number = new randNumbs;
        $number->number = rand(0, 100000);
        $number->save();
        $newId = $number->id;
        return response()->json([
            'id' => $newId,
        ], 200);
    } catch (Exception $e) {
        return response()->json([
            'message' => 'Something went wrong. Contact API support',
        ], 500);
    }
})->middleware('basicAuth');
