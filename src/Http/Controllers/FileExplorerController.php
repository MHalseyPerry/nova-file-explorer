<?php

namespace Vwl\FileExplorer\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Storage;

class FileExplorerController extends Controller
{
    public function index(Request $request)
    {
        $path = $request->path ?? '/';
        $disk = $request->disk;
        $directories = Storage::disk($disk)->directories($path);
        $files = Storage::disk($disk)->files($path);

        $files = str_replace("$path/", '', $files);

        return response()->json([
            'directories' => $directories,
            'files' => $files,
        ]);
    }

    public function disks()
    {
        $default = config('file-explorer.default_disk');
        $disks = config('file-explorer.disks');
        $title = config('file-explorer.tool_title');
        return response()->json([
            'default' => $default,
            'disks' => $disks,
            'title' => $title,
        ]);
    }


    public function show(Request $request)
    {
        return Storage::disk($request->disk)->download("$request->path");
    }
}
