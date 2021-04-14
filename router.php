<?php
$query = array();
if (array_key_exists('QUERY_STRING', $_SERVER)) {
    parse_str($_SERVER['QUERY_STRING'], $query);
}

$sPath = pathinfo($_SERVER["PHP_SELF"]);

$path = str_replace("/router.php", "", "{$sPath["dirname"]}/{$sPath["basename"]}");

try {
    $db = pg_connect('host=localhost port=5432 dbname=sah user=postgres password=admin');
} catch (PDOException $e) {
    echo $e->getMessage();
}

function findByToken($db, $table, $token)
{
    $tokens = pg_select($db, "tokens", array(
        "token" => $token
    ));

    if ($tokens) {
        return pg_select($db, $table, array(
            "user_id" => $tokens[0]["user_id"]
        ));
    }
}


include("./pages{$path}.html");
