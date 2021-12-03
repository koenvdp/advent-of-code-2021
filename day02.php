<?php
include 'common.php';
    
$data = loadData(2);
$depth = 0;
$position = 0;
$aim = 0;
foreach ($data as $line) {
    $tmp = explode(' ', $line);
    $val = trim($tmp[1]);
    switch ($tmp[0]) {
        case 'forward':
            $position += $val;
            $depth += ($aim * $val);
            break;
        case 'down':
            $aim += $val;
            break;
        case 'up':
            $aim -= $val;
            break; 
    }
}

output('Position: ' . $position);
output('Depth: ' . $depth);
output('Total: ' . ($position * $depth), 'green');
