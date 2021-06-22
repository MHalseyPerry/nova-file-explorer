<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Vwl\FileExplorer\Http\Controllers\FileExplorerController;

/*
|--------------------------------------------------------------------------
| Tool API Routes
|--------------------------------------------------------------------------
|
| Here is where you may register API routes for your tool. These routes
| are loaded by the ServiceProvider of your tool. They are protected
| by your tool's "Authorize" middleware by default. Now, go build!
|
*/

Route::get('/files', [FileExplorerController::class, 'index']);
Route::get('/files/disks', [FileExplorerController::class, 'disks']);
Route::get('/files/download', [FileExplorerController::class, 'show']);
