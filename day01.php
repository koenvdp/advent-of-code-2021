<?php
include 'common.php';
    
$data = loadData(1);

$total = 0;
$max = count($data);
$sums = [];
for ($i = 0; $i < $max; $i++) {
    if ($i < $max - 2) {
        $sums[] = $data[$i + 1] + $data[$i + 2] + $data[$i];
    }
}
$max = count($sums);
for ($i = 1; $i < $max; $i++) {
    if ($sums[$i - 1] < trim($sums[$i])) {
        $total++;
    }
}

output($total);