<?php

require "util.php";

$action = $_GET['a'] ?? 'links';

if ($action == 'links') {
    $command = shell_exec('ip addr show');
    $output = criarJson($command);
} else if($action == 'link') {
    $interface = $_GET['link'];
    $commandStatus = shell_exec("ip -s link show {$interface}");
    $output = interfaceStatus($commandStatus, $interface);
}


header("Content-type: application/json; charset=UTF-8");
header("Access-Control-Allow-Origin: *");
echo json_encode($output);

?>