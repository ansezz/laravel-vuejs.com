<?php

namespace Ansezz\WpImporter\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Http\Request;
use LaravelVueJs\Jobs\WpImporter;

class MainController
{
    use DispatchesJobs;

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request): ?\Illuminate\Http\JsonResponse
    {


        /*        $validatedData = $request->validate([
                    'file' => 'required|mimes:xml',
                ]);*/

        $file = $request->file('file');

        $input['file_name'] = time() . '.' . $file->getClientOriginalExtension();

        $destinationPath = storage_path('app' . DIRECTORY_SEPARATOR . 'wp-importer' . DIRECTORY_SEPARATOR . 'in-progress');

        $file = $file->move($destinationPath, $input['file_name']);

        WpImporter::dispatch($file->getFilename());

        return response()->json([
                'success' => true,
                'message' => 'Upload successful',
            ]
        );
    }
}

