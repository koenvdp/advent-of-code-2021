<?php

function loadData($day)
{
    $fileName = 'data/day' . sprintf('%02d', $day)  . '.txt';
    if (!file_exists($fileName)) {
        output('ERROR: file does not exist', 'red');
        exit;
    }
    $lines = file($fileName);
    $data = [];
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line) {
            $data[] = $line;
        }
    }
    
    return $data;
}

function output($txt, $color = null)
{
    $output = '';
    if ($color) {
        $output .= "\033[";
        switch ($color) {
            case 'red':
                $output .= '31m';
                break;
            case 'green':
                $output .= '32m';
                break;
            case 'yellow':
                $output .= '33m';
                break;
            case 'blue':
                $output .= '34m';
                break;
        }
    }
    
    $output .= $txt;
    if ($color) {
        $output .= "\033[0m ";
    }
    $output .= "\n";
    
    echo $output;
}