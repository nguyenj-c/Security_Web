<?php
function RandomString($nb)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randstring = '';
    for ($i = 0; $i < $nb; $i++) {
        $randstring = $characters[rand(0, strlen($characters))];
    }
    return $randstring;
}

function hash_1_000_000(string $algo, int $nb,int $boucle = 36)
{
    $string = RandomString($boucle);
    $debut = microtime(true);
    for ($i = 0; $i < $nb; $i++) {
        $mot = hash($algo, $string);
    }
    $fin = microtime(true);
    return $fin - $debut;
}
$stringSize = ['\\','36','49','72','85'];

$md5 = ['MD5',hash_1_000_000('md5', 1000000), hash_1_000_000('md5', 1000000, 49),
    hash_1_000_000('md5', 1000000, 72), hash_1_000_000('md5', 1000000, 85)];
$sha1 = ['Sha1',hash_1_000_000('sha1', 1000000), hash_1_000_000('sha1', 1000000, 49),
    hash_1_000_000('sha1', 1000000, 72), hash_1_000_000('sha1', 1000000, 85)];
$sha256 = ['Sha256',hash_1_000_000('sha256', 1000000), hash_1_000_000('sha256', 1000000, 49),
    hash_1_000_000('sha256', 1000000, 72), hash_1_000_000('sha256', 1000000, 85)];
$sha512 = ['Sha512',hash_1_000_000('sha512', 1000000), hash_1_000_000('sha512', 1000000, 49),
    hash_1_000_000('sha512', 1000000, 72), hash_1_000_000('sha512', 1000000, 85)];

$table = [$md5,$sha1,$sha256,$sha512];

echo '<!DOCTYPE html>
<html>
<head>
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}
#title {
  text-align: center;
}
tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2 id="title">Hash Table</h2>

<table>
  <tr>';
foreach ($stringSize as $size) {
    echo '<th>' . $size . '</th>';
}
echo'</tr>';
foreach ($table as $hash) {
    echo '<tr>';
    foreach ($hash as $value) {
        echo '<td>' . $value . '</td>';
    }
    echo '</tr>';
}
echo'
</table>

</body>
</html>

';
