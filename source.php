<?php 

$file = $argv[1] ?: "events.log";

$file = fopen($file, "r");
if ($file) {
	$res = [];

	while (($line = fgets($file, 4096)) !== false) {
		if ($line == "\n") continue;

		$line = preg_replace('/\s+/', ' ', $line);
		$arr = explode(" ", $line);
		$arr[1] = str_replace(']', '', $arr[1]);
		$tmp = explode(":", $arr[1]);
		$arr[1] = $tmp[0] . ":" . $tmp[1];

		if ($arr[2] == "NOK") {
			if (isset($res[$arr[1]][0])) {
				$res[$arr[1]][1]++;
			} else {
				$res[$arr[1]][0] = $arr[1];
				$res[$arr[1]][1] = 1;
			}
		}
	}

	foreach ($res as $r) {
		echo $r[0] . " " . $r[1] . "\n";
	}
}
