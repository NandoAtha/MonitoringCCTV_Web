#!/bin/bash

# Path Absolut ke direktori output HLS
OUTPUT_DIR="/mnt/d/Documents/VScode/MonitoringCCTV_Web/monitoringCCTV/public/stream"
mkdir -p "$OUTPUT_DIR"

# --- KAMERA 1: Resepsionis (Channel 1) ---
# Menggunakan -f hls untuk manajemen segmen otomatis dan penghapusan
ffmpeg -rtsp_transport tcp -i "rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=1&subtype=1" \
       -codec:v libx264 -preset veryfast -crf 23 -sc_threshold 0 \
       -map 0:v:0 -map 0:a? \
       -f hls \
       -hls_time 5 \
       -hls_list_size 5 \
       -hls_flags delete_segments \
       "$OUTPUT_DIR/kominfo-resepsionis.m3u8" &

# --- KAMERA 2: PPID (Channel 2) ---
ffmpeg -rtsp_transport tcp -i "rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=2&subtype=1" \
       -codec:v libx264 -preset veryfast -crf 23 -sc_threshold 0 \
       -map 0:v:0 -map 0:a? \
       -f hls \
       -hls_time 5 \
       -hls_list_size 5 \
       -hls_flags delete_segments \
       "$OUTPUT_DIR/kominfo-PPID.m3u8" &

# --- KAMERA 3: Lorong 1 (Channel 3) ---
ffmpeg -rtsp_transport tcp -i "rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=3&subtype=1" \
       -codec:v libx264 -preset veryfast -crf 23 -sc_threshold 0 \
       -map 0:v:0 -map 0:a? \
       -f hls \
       -hls_time 5 \
       -hls_list_size 5 \
       -hls_flags delete_segments \
       "$OUTPUT_DIR/kominfo-lorong1.m3u8" &

# --- KAMERA 4: Lorong 2 (Channel 4) ---
ffmpeg -rtsp_transport tcp -i "rtsp://KadisKominfo:MalangKab2811@10.10.100.26:554/cam/realmonitor?channel=4&subtype=1" \
       -codec:v libx264 -preset veryfast -crf 23 -sc_threshold 0 \
       -map 0:v:0 -map 0:a? \
       -f hls \
       -hls_time 5 \
       -hls_list_size 5 \
       -hls_flags delete_segments \
       "$OUTPUT_DIR/kominfo-lorong2.m3u8" &

# PENGGANTI 'wait' (Membuat Supervisor tetap RUNNING):
exec tail -f /var/log/supervisor/cctv_transcoder_out.log