<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Primjeri ispisa u PHP-u</title>
</head>
<body>
    <h1>Dobrodošli u PHP primjere za ispis</h1>
    
    <!-- Primjer korištenja print s jednom vrijednošću i zagradama -->
    <h2>Primjer s <code>print</code> (sa zagradama)</h2>
    <?php
        print("Ovo je primjer korištenja funkcije print sa zagradama.");
    ?>

    <!-- Primjer korištenja print s jednom vrijednošću bez zagrada -->
    <h2>Primjer s <code>print</code> (bez zagrada)</h2>
    <?php
        print "Ovo je primjer korištenja funkcije print bez zagrada.";
    ?>

    <!-- Primjer korištenja echo s više argumenata -->
    <h2>Primjer s <code>echo</code> (više argumenata)</h2>
    <?php
        $godina = date("Y");
        $doba1 = "Proljeće";
        $doba2 = "Ljeto";
        echo "Trenutna godina je ", $godina, ". ", $doba1, " i ", $doba2, " su godišnja doba.";
    ?>

    <!-- Primjer korištenja print s varijablama -->
    <h2>Primjer s <code>print</code> i varijablama</h2>
    <?php
        $programskiJezik = "PHP";
        print "Ovaj primjer koristi varijablu unutar print funkcije, jezik: $programskiJezik.";
    ?>

    <!-- Primjer korištenja echo za ispis HTML sadržaja -->
    <h2>Primjer s <code>echo</code> za HTML sadržaj</h2>
    <?php
        echo "<p><strong>Ovo je ispisano koristeći <code>echo</code></strong> i uključuje HTML oznake unutar PHP koda.</p>";
    ?>
</body>
</html>
