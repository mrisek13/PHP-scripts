<?php
// Funkcija za dodavanje novog proizvoda
function dodajProizvod($naziv, $opis, $kolicina) {
    $datoteka = 'inventar.txt';
    
    if (!file_exists($datoteka)) {
        $handle = fopen($datoteka, 'w');
        fclose($handle);
    }
    
    $sadrzaj = file($datoteka, FILE_IGNORE_NEW_LINES);
    foreach ($sadrzaj as $linija) {
        list($id, $postojeciNaziv) = explode('|', $linija);
        if ($postojeciNaziv == $naziv) {
            echo "Proizvod s tim nazivom već postoji u skladištu.";
            return;
        }
    }
    
    $id = count($sadrzaj) + 1;
    $noviProizvod = "$id|$naziv|$opis|$kolicina\n";
    file_put_contents($datoteka, $noviProizvod, FILE_APPEND | LOCK_EX);
    echo "Proizvod dodan uspješno.";
}

// Funkcija za dohvat svih proizvoda
function dohvatiProizvode() {
    $datoteka = 'inventar.txt';
    if (!file_exists($datoteka)) return [];
    
    $sadrzaj = file($datoteka, FILE_IGNORE_NEW_LINES);
    $proizvodi = [];
    
    foreach ($sadrzaj as $linija) {
        list($id, $naziv, $opis, $kolicina) = explode('|', $linija);
        $proizvodi[] = ["ID" => $id, "Naziv" => $naziv, "Opis" => $opis, "Količina" => $kolicina];
    }
    return $proizvodi;
}

// Funkcija za sortiranje proizvoda
function sortirajProizvode(&$proizvodi, $kriterij) {
    if ($kriterij === 'naziv') {
        usort($proizvodi, function($a, $b) {
            return strcmp($a['Naziv'], $b['Naziv']);
        });
    } elseif ($kriterij === 'kolicina') {
        usort($proizvodi, function($a, $b) {
            return $a['Količina'] - $b['Količina'];
        });
    }
}

// Funkcija za ažuriranje količine proizvoda
function azurirajKolicinu($id, $novaKolicina) {
    $datoteka = 'inventar.txt';
    if (!file_exists($datoteka)) return;

    $sadrzaj = file($datoteka, FILE_IGNORE_NEW_LINES);
    $noviSadrzaj = '';

    foreach ($sadrzaj as $linija) {
        list($postojeciId, $naziv, $opis, $kolicina) = explode('|', $linija);
        if ($postojeciId == $id) {
            $linija = "$id|$naziv|$opis|$novaKolicina";
        }
        $noviSadrzaj .= $linija . "\n";
    }

    file_put_contents($datoteka, $noviSadrzaj, LOCK_EX);
    echo "Količina ažurirana.";
}

// Funkcija za pretragu proizvoda po nazivu
function pretraziProizvode($pojam) {
    $datoteka = 'inventar.txt';
    if (!file_exists($datoteka)) return [];

    $sadrzaj = file($datoteka, FILE_IGNORE_NEW_LINES);
    $rezultati = [];

    foreach ($sadrzaj as $linija) {
        list($id, $naziv, $opis, $kolicina) = explode('|', $linija);
        if (stripos($naziv, $pojam) !== false) {
            $rezultati[] = ["ID" => $id, "Naziv" => $naziv, "Opis" => $opis, "Količina" => $kolicina];
        }
    }
    return $rezultati;
}

// Funkcija za brisanje proizvoda prema ID-u
function obrisiProizvod($id) {
    $datoteka = 'inventar.txt';
    if (!file_exists($datoteka)) return;

    $sadrzaj = file($datoteka, FILE_IGNORE_NEW_LINES);
    $noviSadrzaj = '';

    foreach ($sadrzaj as $linija) {
        list($postojeciId) = explode('|', $linija);
        if ($postojeciId != $id) {
            $noviSadrzaj .= $linija . "\n";
        }
    }

    file_put_contents($datoteka, $noviSadrzaj, LOCK_EX);
    echo "Proizvod obrisan.";
}

// Obrada zahtjeva iz formi
$proizvodi = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['dodaj'])) {
        dodajProizvod($_POST['naziv'], $_POST['opis'], $_POST['kolicina']);
    } elseif (isset($_POST['azuriraj'])) {
        azurirajKolicinu($_POST['id'], $_POST['novaKolicina']);
    } elseif (isset($_POST['obrisi'])) {
        obrisiProizvod($_POST['id']);
    } elseif (isset($_POST['pretrazi'])) {
        $proizvodi = pretraziProizvode($_POST['pojam']); // Prikaži samo rezultate pretrage
    }
}

// Prikaz svih proizvoda ili rezultata pretrage
if (empty($proizvodi)) {
    $proizvodi = dohvatiProizvode();
}

// Primjena sortiranja ako je odabrano
if (isset($_GET['sortiraj'])) {
    sortirajProizvode($proizvodi, $_GET['sortiraj']);
}
?>

<!DOCTYPE html>
<html lang="hr">
<head>
    <meta charset="UTF-8">
    <title>Upravljanje inventarom</title>
</head>
<body>

<h1>Dodaj novi proizvod</h1>
<form action="inventar.php" method="post">
    <input type="text" name="naziv" placeholder="Naziv proizvoda" required>
    <input type="text" name="opis" placeholder="Opis proizvoda" required>
    <input type="number" name="kolicina" placeholder="Količina" required>
    <button type="submit" name="dodaj">Dodaj proizvod</button>
</form>

<h1>Ažuriraj količinu proizvoda</h1>
<form action="inventar.php" method="post">
    <input type="number" name="id" placeholder="ID proizvoda" required>
    <input type="number" name="novaKolicina" placeholder="Nova količina" required>
    <button type="submit" name="azuriraj">Ažuriraj količinu</button>
</form>

<h1>Pretraga proizvoda</h1>
<form action="inventar.php" method="post">
    <input type="text" name="pojam" placeholder="Pretraga po nazivu" required>
    <button type="submit" name="pretrazi">Pretraži</button>
</form>

<h1>Brisanje proizvoda</h1>
<form action="inventar.php" method="post">
    <input type="number" name="id" placeholder="ID proizvoda" required>
    <button type="submit" name="obrisi">Obriši proizvod</button>
</form>

<h1>Sortiranje proizvoda</h1>
<form action="inventar.php" method="get">
    <select name="sortiraj">
        <option value="naziv">Naziv</option>
        <option value="kolicina">Količina</option>
    </select>
    <button type="submit">Sortiraj</button>
</form>

<h1>Popis svih proizvoda</h1>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Naziv</th>
        <th>Opis</th>
        <th>Količina</th>
    </tr>
    <?php foreach ($proizvodi as $proizvod): ?>
        <tr>
            <td><?= htmlspecialchars($proizvod['ID']) ?></td>
            <td><?= htmlspecialchars($proizvod['Naziv']) ?></td>
            <td><?= htmlspecialchars($proizvod['Opis']) ?></td>
            <td><?= htmlspecialchars($proizvod['Količina']) ?></td>
        </tr>
    <?php endforeach; ?>
</table>

</body>
</html>
