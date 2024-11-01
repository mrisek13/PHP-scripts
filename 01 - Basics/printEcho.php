<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Primjeri printf i sprintf u PHP-u</title>
</head>
<body>
    <h1>Primjeri printf i sprintf</h1>

    <!-- Korištenje printf -->
    <h2>Korištenje <code>printf</code></h2>
    <?php
        printf("Tjedan ima: %d dana.<br>", 7);
        printf("Tjedan ima: %d dana i %d sati.<br>", 7, 168);
        
        // Korištenje typespecifiers
        $number = 255;
        printf("Binarni broj: %b<br>", $number); // Binarni prikaz
        printf("Oktalni broj: %o<br>", $number); // Oktalni prikaz
        printf("Heksadecimalni broj (mala slova): %x<br>", $number); // Heksadecimalni prikaz
        printf("Heksadecimalni broj (velika slova): %X<br>", $number); // Heksadecimalni prikaz
    ?>

    <!-- Korištenje sprintf -->
    <h2>Korištenje <code>sprintf</code></h2>
    <?php
        $formattedString = sprintf("Tjedan ima: %d dana i %d sati.", 7, 168);
        echo $formattedString; // Ispis formatiranog stringa

        // Korištenje sprintf s binarnim i oktalnim brojevima
        $binaryString = sprintf("Binarni broj: %b", $number);
        echo "<br>" . $binaryString;

        $octalString = sprintf("Oktalni broj: %o", $number);
        echo "<br>" . $octalString;
    ?>
</body>
</html>

