<?php
parse_str($_SERVER['QUERY_STRING'], $query);

$method = $_SERVER['REQUEST_METHOD'];

$sPath = pathinfo($_SERVER["PHP_SELF"]);

$path = str_replace("/server.php", "", "{$sPath["dirname"]}/{$sPath["basename"]}");

try {
    $db = pg_connect('host=localhost port=5432 dbname=sah user=postgres password=admin');
} catch (PDOException $e) {
    echo $e->getMessage();
}


$response = array(
    "status" => 404,
    "data" => "Not found",
);

switch ($path) {
    case "/login":
        if ($method === 'POST') {
            $users = pg_select($db, "users", array(
                "email" => $query["email"]
            ));

            if ($users and $users[0]["password"] === $query["password"]) {
                $token = uniqid("user-");
                pg_insert($db, "tokens", array(
                    "user_id" => $users[0]["id"],
                    "token" => $token
                ));
                $response["status"] = 200;
                $response["data"] = $token;
            }
        }
        break;
    case "/token":
        $tokens = pg_select($db, "tokens", array(
            "token" => $query["token"]
        ));

        if ($tokens) {
            $users = pg_select($db, "users", array(
                "id" => $tokens[0]["user_id"]
            ));

            if ($users) {
                $response["status"] = 200;
                $response["data"] = "OK";
            }
        }
        break;
}

http_response_code($response['status']);
echo json_encode($response);
