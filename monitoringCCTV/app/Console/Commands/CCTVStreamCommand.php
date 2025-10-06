<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;
use App\Models\Camera;
use Illuminate\Support\Facades\File;

class CCTVStreamCommand extends Command
{
    protected $signature = 'cctv:stream';
    protected $description = 'Menjalankan stream CCTV dinamis berdasarkan database';

    protected $outputDir = 'public/stream';
    protected $processes = [];

    public function handle()
    {
        $this->info('Memulai streaming CCTV dinamis...');
        $this->initOutputDir();

        while (true) {
            $cameras = Camera::where('is_active', true)->get();

            // Jalankan stream baru
            foreach ($cameras as $camera) {
                if (!isset($this->processes[$camera->id])) {
                    $this->startStream($camera);
                }
            }

            // Hentikan stream yang tidak aktif
            foreach ($this->processes as $id => $process) {
                if (!$cameras->contains('id', $id)) {
                    $this->stopStream($id);
                }
            }

            sleep(10); // cek ulang setiap 10 detik
        }
    }

    protected function initOutputDir()
    {
        if (!File::exists(public_path('stream'))) {
            File::makeDirectory(public_path('stream'), 0755, true);
        }
    }

    protected function startStream($camera)
    {
        $outputPath = public_path("stream/{$camera->name}.m3u8");

        $cmd = [
            'ffmpeg',
            '-rtsp_transport', 'tcp',
            '-i', $camera->rtsp_url,
            '-codec:v', 'libx264',
            '-preset', 'veryfast',
            '-crf', '23',
            '-sc_threshold', '0',
            '-f', 'hls',
            '-hls_time', '5',
            '-hls_list_size', '5',
            '-hls_flags', 'delete_segments',
            $outputPath,
        ];

        $process = new Process($cmd);
        $process->start();

        $this->processes[$camera->id] = $process;
        $this->info("Stream dimulai: {$camera->name}");
    }

    protected function stopStream($id)
    {
        $process = $this->processes[$id];
        $process->stop(1);
        unset($this->processes[$id]);
        $this->warn("Stream dihentikan untuk kamera ID: {$id}");
    }
}
