<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FileController extends Controller
{
    /**
     * Tampilkan file inline (view di browser).
     *
     * @param string $filename
     */
    public function view(string $filename)
    {
        $path = storage_path('app/public/form-images/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => mime_content_type($path),
            'Content-Disposition' => 'inline; filename="'.$filename.'"'
        ]);
    }

    /**
     * Download file.
     *
     * @param string $filename
     */
    public function download(string $filename)
    {
        $path = storage_path('app/public/form-images/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path, $filename);
    }
}

