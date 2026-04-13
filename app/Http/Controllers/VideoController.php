<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function stream()
    {
        $path = storage_path("app/videos/1234.mkv");

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path, [
            'Content-Type' => 'video/mp4',
        ]);
    }

    public function chunkStream(Request $request)
    {
        $path = storage_path("app/videos/demo.mp4");

        if (!file_exists($path)) {
            abort(404);
        }

        $size = filesize($path);
        $fileStream = fopen($path, 'rb');

        $start = 0;
        $end = $size - 1;

        $headers = [
            'Content-Type' => 'video/mp4',
            'Accept-Ranges' => 'bytes',
        ];

        // Handle range request (VERY IMPORTANT)
        if ($request->header('Range')) {
            $range = $request->header('Range');
            $range = str_replace('bytes=', '', $range);
            [$startRange, $endRange] = explode('-', $range);

            $start = intval($startRange);
            $end = $endRange ? intval($endRange) : $end;

            $length = $end - $start + 1;

            fseek($fileStream, $start);

            $headers['Content-Range'] = "bytes $start-$end/$size";
            $headers['Content-Length'] = $length;

            return response()->stream(function () use ($fileStream, $length) {

                $chunk = 1024 * 8;
                $sent = 0;

                while (!feof($fileStream) && $sent < $length) {
                    $buffer = fread($fileStream, $chunk);
                    echo $buffer;
                    $sent += strlen($buffer);
                    flush();
                }

                fclose($fileStream);
            }, 206, $headers);
        }

        // Full stream fallback
        return response()->stream(function () use ($fileStream) {
            fpassthru($fileStream);
            fclose($fileStream);
        }, 200, $headers);
    }
}
