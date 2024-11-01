<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>PHP programiranje - Zadatak 5</title>
</head>
<body>
    <h1>PHP programiranje - Zadatak 5</h1>
    
    <!-- 1. Uklanjanje nepoželjnih riječi -->
    <?php
    function uklanjanjeNezeljenihRijeci($text, $nezeljeneRijeci) {
        $rijeci = explode(' ', $text);
        $ocisceneRijeci = [];
        
        foreach ($rijeci as $rijec) {
            if (!in_array($rijec, $nezeljeneRijeci)) {
                $ocisceneRijeci[] = $rijec;
            }
        }
        
        return implode(' ', $ocisceneRijeci);
    }

    $text = "Mila kano si nam slavna, mila si nam ti jedina. Mila kuda si nam ravna. Mila kuda si planina.";
    $nezeljeneRijeci = ["kano", "Mila", "kuda"];
    echo uklanjanjeNezeljenihRijeci($text, $nezeljeneRijeci);
	echo "<br><br>";
    ?>
    
    <!-- 2. Izdvajanje ključnih informacija -->
    <?php
    function izdvojiKljucne($text) {
        preg_match_all('/\b\w{5,}\b/', $text, $matches);
        foreach ($matches[0] as $rijec) {
            echo $rijec . " ";
        }
    }

    $text = "Lijepa naša domovino, Oj junačka zemljo mila.";
    izdvojiKljucne($text);
    echo "<br><br>";
    ?>
    
    <!-- 3. Prebrojavanje pojavljivanja riječi -->
    <?php
    function brojiPonavljanja($text, $rijec) {
        $text = strtolower($text);
        $rijec = strtolower($rijec);
        $rijeci = str_word_count($text, 1);
        
        $brojac = 0;
        foreach ($rijeci as $r) {
            if ($r == $rijec) {
                $brojac++;
            }
        }
        
        return $brojac;
    }

    function najcesceRijeci($text) {
        $text = strtolower($text);
        $rijeci = str_word_count($text, 1);
        $brojaci = array_count_values($rijeci);
        arsort($brojaci);
        return array_slice(array_keys($brojaci), 0, 3);
    }

    $text = "Lijepa nasa domovino. Oj junačka zemljo mila. Stare slave djedovino da bi vazda sretna bila. Mila kano si nam slavna, mila si nam ti jedina. Mila kuda si nam ravna. Mila kuda si planina.";
    $rijec = "mila";
    echo "Riječ '$rijec' se pojavljuje " . brojiPonavljanja($text, $rijec) . " puta.\n";
    $kljucneRijeci = najcesceRijeci($text);
    echo "Najčešće riječi: " . implode(', ', $kljucneRijeci) . "\n";
	echo "<br><br>";
    ?>

    <!-- 4. Kraćenje recenzije -->
    <?php
    function skratiTekst($text, $maxDuzina) {
        if (strlen($text) <= $maxDuzina) {
            return $text;
        }
        
        return substr($text, 0, $maxDuzina - 3) . "...";
    }

    $text = "Lijepa nasa domovino, oj junačka zemljo mila";
    $maxDuzina = 30;
    echo skratiTekst($text, $maxDuzina);
    ?>

</body>
</html>
