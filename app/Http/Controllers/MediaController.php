<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Response;
class MediaController extends Controller {

    public function showMedia($folder, $filename) {
        $path = base_path("dashboard/uploads/{$folder}/{$filename}");
        if (!file_exists($path)) {
            abort(404);
        }
        $mimeType = mime_content_type($path);
        return Response::file($path, ['Content-Type' => $mimeType]);
    }
}
