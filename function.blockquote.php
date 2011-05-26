<?php
function toArray($str, $currLevel = 0, $i = 0) {
  $return = array();
  $lines = explode("\n", $str);
  for($j = count($lines); $i < $j; $i++) {
    $line = trim($lines[$i]);
    $level = preg_replace('/^((?:>|\s)+).*/','\1', $line);
    $level = substr_count($level, '>');
    if($level == $currLevel) {
      array_push($return, preg_replace('/^((?:>|\s)+)(.*)/','\2', $line));
    }
    else if($level > $currLevel) {
      array_push($return, toArray(join("\n", $lines), $currLevel  + 1, &$i));
    } else if($level < $currLevel) {
      $i--;
      return $return;
    }
  }
  
  return $return;
}

function toQuote($lines) {
  $return = "<blockquote>\n";
  foreach($lines as $line) {
    if(is_array($line)) {
      $return .= toQuote($line);
    }
    else {
      $return .= $line . "\n"; 
    }
  }
  $return .= "</blockquote>\n";
  return $return;
}