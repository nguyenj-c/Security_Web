<?php

function openssl_1_000(string $algo, int $nb, int $length)
{
    $string = "La cryptographie est une des disciplines de la cryptologie s'attachant à protéger des messages (assurant confidentialité, authenticité et intégrité) en s'aidant souvent de secrets ou clés. Elle se distingue de la stéganographie qui fait passer inaperçu un message dans un autre message alors que la cryptographie rend un message supposément inintelligible à autre que qui-de-droit.";
    $key = openssl_random_pseudo_bytes($length);

    $ivlen = openssl_cipher_iv_length($algo);
    $iv = openssl_random_pseudo_bytes($ivlen);

    $debut = microtime(true);
    for ($i = 0; $i < $nb - 1; $i++) {
        $hashResult = openssl_encrypt($string, $algo, $key , 0 , $iv );
        $hashDecrypt = openssl_decrypt($hashResult, $algo, $key , 0 , $iv );
    }
    $fin = microtime(true);

    return $fin - $debut;
}
$stringSize = ['Itération','128','192','256'];

$openssl_1000 = ['1 000 fois',openssl_1_000('AES128', 1000, 128/4), openssl_1_000('AES192', 1000, 192/4),
    openssl_1_000('AES256', 1000, 256/4)];
$openssl_100000 = ['100 000 fois',openssl_1_000('AES128', 100000, 128/4), openssl_1_000('AES192', 100000, 192/4),
    openssl_1_000('AES256', 100000, 256/4)];

$openssl = [$openssl_1000,$openssl_100000];

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

<h2 id="title">OpenSSL Table</h2>

<table>
  <tr>';
foreach ($stringSize as $size) {
    echo '<th>' . $size . '</th>';
}
echo'</tr>';
foreach ($openssl as $hash) {
    echo'<tr>';
    foreach ($hash as $value) {
        echo '<td>' . $value . '</td>';
    }
    echo'</tr>';
}

echo'</tr>
</table>

</body>
</html>';

