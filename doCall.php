<?php

include_once('Ajam.php');

$url = "http://<ip>:<port>";
$login = "<user_manager>";
$secret = "<secret_manager>";
$number = "<number_call>";
$outcontext = "<context_number_call>";
$exten = "<internal_number>";
$context = "<internal_context>";
$priority = 1;
$vars = "test=pouet";

$config = array ( "urlraw" => $url . "/rawman",
                  "admin" => $login,
                  "secret" => $secret,
                  "authtype" => "plaintext",
                  "cookiefile" => "/tmp/ajam.cookies",
                  "debug" => null
                );

$connect = new Ajam($config);

$params = array ( "Channel" => "Local/". $number ."@" . $outcontext,
                  "Exten" => $exten,
                  "Context" => $context,
                  "Priority" => $priority,
                  "Async" => 1,
                  "Variable" => $vars
                );

$connect->doCommand("Originate", $params);

?>
