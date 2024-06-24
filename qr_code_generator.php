<?php
// Fungsi untuk mengirimkan permintaan ke API QR Code Generator
function generateQRCode($qr_code_text, $access_token) {
    // URL endpoint API QR Code Generator
    $api_url = "https://api.qr-code-generator.com/v1/create?access-token=" . $access_token;

    // Data untuk dikirim sebagai body request
    $data = array(
        "frame_name" => "no-frame",
        "qr_code_text" => $qr_code_text,
        "image_format" => "SVG",
        "qr_code_logo" => "scan-me-square" // Opsional, untuk menggunakan logo pada QR Code
    );

    // Konversi data menjadi format JSON
    $data_json = json_encode($data);

    // Konfigurasi CURL untuk membuat request POST
    $ch = curl_init($api_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Eksekusi CURL dan ambil responsenya
    $response = curl_exec($ch);
    curl_close($ch);

    // Dekode respons dari JSON ke array
    $qr_code_data = json_decode($response, true);

    return $qr_code_data;
}
?>
