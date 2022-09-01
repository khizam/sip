<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

function format_uang($angka)
{
    return number_format($angka, 0, ',', '.');
}

function terbilang($angka)
{
    $angka = abs($angka);
    $baca = array('', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan', 'sepuluh', 'sebelas');
    $terbilang = '';

    if ($angka < 12) {
        $terbilang = ' ' . $baca[$angka];
    } elseif ($angka < 20) {
        $terbilang = terbilang($angka - 10) . ' belas';
    } elseif ($angka < 100) {
        $terbilang = terbilang($angka / 10) . ' puluh' . terbilang($angka % 10);
    } elseif ($angka < 200) {
        $terbilang = ' seratus' . terbilang($angka - 100);
    } elseif ($angka < 1000) { //999
        $terbilang = terbilang($angka / 100) . ' ratus' . terbilang($angka % 100);
    } elseif ($angka < 2000) { //1000 - 1999
        $terbilang = ' seribu' . terbilang($angka - 1000);
    } elseif ($angka < 1000000) {
        $terbilang = terbilang($angka / 1000) . 'ribu' . terbilang($angka % 1000);
    } elseif ($angka < 1000000000) {
        $terbilang = terbilang($angka / 1000000) . ' juta' . terbilang($angka % 1000000);
    }

    return $terbilang;
}

function tanggal_indonesia($tgl, $tampil_hari = true)
{
    $nama_hari = array(
        'Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'
    );

    $nama_bulan = array(
        1 =>
        'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
    );

    $tahun = substr($tgl, 0, 4);
    $bulan = $nama_bulan[(int) substr($tgl, 5, 2)];
    $tanggal = substr($tgl, 8, 2);
    $text = '';

    if ($tampil_hari) {
        $urutan_hari = date('w', mktime(0, 0, 0, substr($tgl, 5, 2), $tanggal, $tahun));
        $hari = $nama_hari[$urutan_hari];
        $text .= "$hari, $tanggal $bulan $tahun";
    } else {
        $text .= "$tanggal $bulan $tahun";
    }

    return $text;
}

function tambah_nol_didepan($value, $threshold = null)
{

    return sprintf("%0". $threshold . "s", $value);
}

// function jsonResponse($data='', $status=Response::HTTP_OK, array $headers = []) {

//     return sprintf("%0" . $threshold . "s", $value);
// }

function jsonResponse($data = '', $status = Response::HTTP_OK, array $headers = [])
{

    return response()->json($data, $status, $headers);
}

if (!function_exists('mrPasienAuto')) {
    function kodeOtomatis($prefix = 'BR')
    {
        // BR tahun-bulan-tanggal-random angka 1-9999
        return $prefix . date('ymd', strtotime(now())) . random_int(1, 9999);
    }
}

if (!function_exists('mrLabAuto')) {
    function kodeAuto($prefix = 'LB')
    {
        return $prefix . date('ymd', strtotime(now())) . random_int(1, 9999);
    }
}

if (!function_exists('mrRequestAuto')) {
    function kodeRequest($prefix = 'RQP')
    {
        return $prefix . date('ymd', strtotime(now())) . random_int(1, 9999);
    }
}
