<?php

function criarJson($commandOutput){
  $result = [];

  $regex = "/(\d*):\s(\S*):.*mtu\s(\S*)\.*.*state\s(\S*)\s.*\n\s*\S*\s(\S*)\s\S*\s(\S*).*\n\s*inet\s(\S*)/";
  preg_match_all($regex, $commandOutput, $matches);

  foreach ($matches[1] as $index => $user) {
    $result[] = [
      "id" => $matches[1][$index],
      "name" => $matches[2][$index],
      "mtu" => $matches[3][$index],
      "state" => $matches[4][$index],
      "mac" => $matches[5][$index],
      "macbrd" => $matches[6][$index],
      "ip" => $matches[7][$index],
    ];
  }

  return $result;
}

function interfaceStatus($commandStatus, $interface) {
  $resultStatus = ['name' => $interface];
  
  $regexStatus = "/(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)\s+(\d+)/";
  preg_match_all($regexStatus, $commandStatus, $matchesStatus);
  
  $resultStatus['stats'] = [];

  foreach ($matchesStatus[1] as $indexStatus => $userStatus){
    $flow = $indexStatus == 0 ? 'rx' : 'tx';
    $resultStatus['stats'][$flow] = [
        "bytes" => $matchesStatus[1][$indexStatus],
        "packets" => $matchesStatus[2][$indexStatus],
        "errors" => $matchesStatus[3][$indexStatus],
        "dropped" => $matchesStatus[4][$indexStatus],
        "overrun" => $matchesStatus[5][$indexStatus],
        "mcast" => $matchesStatus[6][$indexStatus]

    ];

  }

  return $resultStatus;
  
}

?>