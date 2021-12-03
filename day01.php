<?php
include 'common.php';
    
class day01 extends abstractSolution {
    
    public function run()
    {
        $total = 0;
        $max = count($this->data);
        $sums = [];
        for ($i = 0; $i < $max; $i++) {
            if ($i < $max - 2) {
                $sums[] = $this->data[$i + 1] + $this->data[$i + 2] + $this->data[$i];
            }
        }
        $max = count($sums);
        for ($i = 1; $i < $max; $i++) {
            if ($sums[$i - 1] < trim($sums[$i])) {
                $total++;
            }
        }

        $this->output($total);
    }
}

$obj = new day01(1);
$obj->run();