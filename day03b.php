<?php
include 'common.php';
    
class day03b extends abstractSolution {
    
    public function run()
    {
        $oxygenRating = $this->calcRating(true);
        $co2Rating = $this->calcRating(false);

        $this->output('Oxygen generator rating: ' . $oxygenRating . ' (' . bindec($oxygenRating) . ')');
        $this->output('CO2 scrubber rating: ' . $co2Rating . ' (' . bindec($co2Rating) . ')');
        $this->output('Solution: ' . (bindec($oxygenRating) * bindec($co2Rating)), 'green');
    }
    
    protected function calcRating(bool $mostCommon)
    {
        $data = $this->data;
        $pos = 0;
        while (count($data) > 1) {
            $bitsCount = $this->getBitsCount($data, $pos);
            if (($mostCommon && $bitsCount[0] > $bitsCount[1]) || (!$mostCommon && $bitsCount[0] <= $bitsCount[1])) {
                $bit = 0;
            } else {
                $bit = 1;
            }
            $newData = [];
            foreach ($data as $line) {
                if ($line[$pos] == $bit) {
                    $newData[] = $line;
                }
            }
            $data = $newData;
            $pos++;
        }
        
        if (isset($data[0])) {
            return $data[0];
        }
        
        $this->output('Is this supposed to happen? Did not find any matching number.', 'red', true);
    }
    
    protected function getBitsCount($data, $pos)
    {
        $bitsCount = [0, 0];
        foreach ($data as $key => $line) {
            if (!isset($line[$pos])) {
                $this->output('No bit at position ' . $pos, 'red', true);
            }
            if (!isset($bitsCount[$line[$pos]])) {
                $this->output('Invalid bit on line ' . ($key + 1), 'red', true);
            }
            $bitsCount[$line[$pos]]++;
        }
        
        return $bitsCount;
    }
}

$obj = new day03b(3);
$obj->run();