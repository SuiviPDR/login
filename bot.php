<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userInput = $_POST["user_input"];

    // إعداد الطلب للتفاعل مع نموذج ChatGPT
    $url = "https://api.openai.com/v1/completions";
    $data = json_encode([
        "prompt" => $userInput,
        "model" => "text-davinci-003",
        "max_tokens" => 150
    ]);
    $apiKey = "YOUR_API_KEY"; // يجب استبداله بمفتاح API الخاص بك

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // إرسال الطلب واستقبال الرد
    $response = curl_exec($ch);
    curl_close($ch);

    // إرسال الرد إلى الواجهة الأمامية
    echo $response;
}
