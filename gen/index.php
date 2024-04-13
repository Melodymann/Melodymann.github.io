<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $bin = $_POST['bin'];
    if (preg_match('/^\d{6}$/', $bin)) {
        $generatedNumbers = [];
        for ($i = 0; $i < 10; $i++) {
            $cardNumber = $bin . generateRandomSequence(9);
            $cardNumber .= calculateLuhnDigit($cardNumber);
            $generatedNumbers[] = $cardNumber;
        }
        foreach ($generatedNumbers as $number) {
            echo $number . "<br>";
        }
    } else {
        echo "Invalid BIN. Please enter a 6-digit BIN.";
    }
}

function generateRandomSequence($length) {
    $result = '';
    for ($i = 0; $i < $length; $i++) {
        $result .= mt_rand(0, 9);
    }
    return $result;
}

function calculateLuhnDigit($number) {
    $sum = 0;
    $numDigits = strlen($number);
    $parity = $numDigits % 2;

    for ($i = 0; $i < $numDigits; $i++) {
        $digit = $number[$i];
        if ($i % 2 == $parity) {
            $digit *= 2;
            if ($digit > 9) {
                $digit -= 9;
            }
        }
        $sum += $digit;
    }
    return (10 - $sum % 10) % 10;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CC Generator</title>
</head>
<body>
    <h1>CC Generator</h1>
    <form action="generate.php" method="post">
        <label for="bin">Enter BIN:</label>
        <input type="text" id="bin" name="bin" required>
        <button type="submit">Generate</button>
    </form>
</body>
</html>
