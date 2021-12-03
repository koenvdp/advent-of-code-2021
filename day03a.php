<?php
include 'common.php';

class day03a extends abstractSolution {
    
    public function run()
    {
        $gamma = $epsilon = '';
        $bitsCount = [];
        for ($i = 0; $i < $max = strlen($this->data[0]); $i++) {
            $bitsCount[$i] = [0, 0];
        }

        foreach ($this->data as $key => $line) {
            for ($i = 0; $i < $max = strlen($line); $i++) {
                if (!isset($bitsCount[$i][$line[$i]])) {
                    $this->output('Invalid bit on line ' . ($key + 1), 'red', true);
                }
                $bitsCount[$i][$line[$i]]++;
            }
        }

        foreach ($bitsCount as $key => $arr) {
            if ($arr[0] > $arr[1]) {
                $gamma .= '0';
                $epsilon .= '1';
            } else {
                $gamma .= '1';
                $epsilon .= '0';
            }
        }

        $this->output('Gamma: ' . $gamma . ' (' . bindec($gamma) . ')');
        $this->output('Epsilon: ' . $epsilon . ' (' . bindec($epsilon) . ')');
        $this->output('Solution: ' . (bindec($gamma) * bindec($epsilon)), 'green');
    }
}

$obj = new day03a(3);
$obj->run();