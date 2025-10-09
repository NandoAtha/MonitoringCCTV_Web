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

    protected $outputDir = 'public/streams';
    protected $processes = [];

    public function handle()
    {
        $this->info('Memulai streaming CCTV dinamis...');
        $this->initOutputDir();

        while (true) {
            $cameras = Camera::where('online', true)->get();

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
        if (!File::exists(public_path('streams'))) {
            File::makeDirectory(public_path('streams'), 0755, true);
        }
    }

    protected function startStream($camera)
    {
        $outputPath = public_path("streams/{$camera->name}.m3u8");

        $cmd = [
            'C:\ffmpeg\bin\ffmpeg.exe',
            '-rtsp_transport', 'tcp',
            '-i', $camera->rtsp_url,
            '-codec:v', 'libx264',
            '-preset', 'veryfast',
            '-crf', '23',
            '-sc_threshold', '0',
            '-f', 'hls',
            '-hls_time', '2',
            '-hls_list_size', '3',
            '-hls_flags', 'delete_segments',
            $outputPath,
        ];

        // Simpan log ffmpeg agar bisa dicek
        $logFile = storage_path("logs/ffmpeg_{$camera->id}.log");
        $process = new Process($cmd);
        $process->setTimeout(0); // biar tidak auto stop
        $process->start(function ($type, $buffer) use ($logFile) {
            File::append($logFile, $buffer);
        });

        $this->processes[$camera->id] = $process;
        $this->info("Stream dimulai: {$camera->name} → {$outputPath}");
    }


    protected function stopStream($id)
    {
        $process = $this->processes[$id];
        $process->stop(1);
        unset($this->processes[$id]);
        $this->warn("Stream dihentikan untuk kamera ID: {$id}");
    }
}
