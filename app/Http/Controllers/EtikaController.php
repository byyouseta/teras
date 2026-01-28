<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class EtikaController extends Controller
{
    public function main(Request $request)
    {
        return view('etika.dashboard');
    }

    public function pelaporan(Request $request)
    {
        return view('etika.pelaporan');
    }

    public function tindaklanjut(Request $request)
    {
        return view('etika.tindaklanjut');
    }

    public function download($file, Request $request)
    {
        $path = 'etika/pelaporan/' . $file;

        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $full = Storage::disk('public')->path($path);

        if ($request->has('preview')) {
            // tampilkan inline (iframe)
            return response()->file($full, [
                'Content-Type' => mime_content_type($full),
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        }

        // force download
        return response()->download($full);
    }

    public function fileRtl($file, Request $request)
    {
        $path = 'etika/tindaklanjut/' . $file;

        if (! Storage::disk('public')->exists($path)) {
            abort(404);
        }

        $full = Storage::disk('public')->path($path);

        if ($request->has('preview')) {
            // tampilkan inline (iframe)
            return response()->file($full, [
                'Content-Type' => mime_content_type($full),
                'Cache-Control' => 'no-store, no-cache, must-revalidate, max-age=0',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
        }

        // force download
        return response()->download($full);
    }
}
