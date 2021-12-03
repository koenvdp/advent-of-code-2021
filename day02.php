<?php
include 'common.php';

class day02 extends abstractSolution {
    
    public function run()
    {
        $depth = 0;
        $position = 0;
        $aim = 0;
        foreach ($this->data as $line) {
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

        $this->output('Position: ' . $position);
        $this->output('Depth: ' . $depth);
        $this->output('Total: ' . ($position * $depth), 'green');
    }
}

$obj = new day02(2);
$obj->run();