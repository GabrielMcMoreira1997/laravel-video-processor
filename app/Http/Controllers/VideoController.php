<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use FFMpeg\FFMpeg;
use FFMpeg\Format\Video\X264;

class VideoController extends Controller
{
    public function index()
    {
        // Pegue o vídeo mais recente para exibição (ou customize conforme necessário)
        $video = \Storage::disk('public')->files('videos');
        $lastVideo = $video ? end($video) : null;
        return view('welcome', ['video' => $lastVideo]);
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('video')) {
            $file = $request->file('video');
            $path = $file->store('videos', 'public');

            // Processa o vídeo para H.264
            $this->processVideo(storage_path("app/public/{$path}"));
            return back()->with('success', 'Upload realizado com sucesso!')->with('path', $path);
        } else {
            return back()->withErrors('Nenhum arquivo foi enviado.');
        }
    }

    private function processVideo($videoPath)
    {
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoPath);

        $format = new X264('aac', 'libx264');
        $format->setAdditionalParameters(['-preset', 'slow', '-crf', '20']);

        $outputPath = str_replace('.mp4', '_processed.mp4', $videoPath);
        $video->save($format, $outputPath);
    }
}