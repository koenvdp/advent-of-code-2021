<?php
include 'common.php';

class Board {
    /** @var int */
    protected $id;

    /** @var array */
    protected $rows = [];

    /** @var array */
    protected $cols = [];

    public function __construct(int $boardId)
    {
        $this->setId($boardId);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id)
    {
        $this->id = $id;
    }

    /**
     * @param string $data
     */
    public function addRow(string $data)
    {
        $nrs = [];
        $max = strlen($data);
        for ($i = 0, $j = 1; $i < $max; $i+=3, $j++) {
            $nr = (int)($data[$i] . $data[$i + 1]);
            $nrs[] = $nr;
            if (!isset($this->cols[$j])) {
                $this->cols[$j] = new DataSet();
            }
            $this->cols[$j]->addData($nr);
        }

        $rowId = count($this->rows);
        $this->rows[$rowId] = new DataSet($nrs);
    }

    /**
     * @param int $nr
     * @return bool
     */
    public function setDrawnNumber($nr): bool
    {
        $isComplete = false;
        foreach ($this->rows as $row) {
            if ($row->selectNumber($nr)) {
                $isComplete = true;
            }
        }
        foreach ($this->cols as $col) {
            if ($col->selectNumber($nr)) {
                $isComplete = true;
            }
        }

        return $isComplete;
    }

    /**
     * @param int $nr;
     * @return int
     */
    public function getSolution(int $nr)
    {
        $unselected = [];
        foreach ($this->rows as $row) {
            $unselected = array_merge($unselected, $row->getUnselected());
        }
        foreach ($this->cols as $col) {
            $unselected = array_merge($unselected, $col->getUnselected());
        }

        return array_sum(array_unique($unselected)) * $nr;
    }
}

class DataSet
{
    /** @var array */
    protected $data = [];

    /** @var int */
    protected $selected = 0;

    public function __construct(array $data = [])
    {
        $this->setData($data);
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData(array $data)
    {
        foreach ($data as $value) {
            $this->data[$value] = false;
        }
    }

    /**
     * @param mixed $value
     */
    public function addData($value)
    {
        $this->data[$value] = false;
    }

    /**
     * @return int
     */
    public function getSelected(): int
    {
        return $this->selected;
    }

    /**
     * @param int $selected
     */
    public function setSelected(int $selected)
    {
        $this->selected = $selected;
    }

    /**
     * @return bool
     */
    public function isComplete(): bool
    {
        return $this->selected == count($this->data);
    }

    /**
     * @param int $nr;
     * @return bool
     */
    public function selectNumber(int $nr): bool
    {
        foreach ($this->data as $key => $val) {
            if ($key == $nr) {
                if (!$val) {
                    $this->selected++;
                }
                $this->data[$key] = true;
            }
        }

        return $this->isComplete();
    }

    /**
     * @return array
     */
    public function getUnselected(): array
    {
        $arr = [];
        foreach ($this->data as $key => $val) {
            if (!$val) {
                $arr[] = $key;
            }
        }

        return $arr;
    }
}

class day04a extends abstractSolution
{
    protected $draw = [
        63,23,2,65,55,94,38,20,22,39,5,98,9,60,80,45,99,68,12,3,6,34,64,10,70,69,95,96,83,81,32,30,42,73,52,48,92,28,37,
        35,54,7,50,21,74,36,91,97,13,71,86,53,46,58,76,77,14,88,78,1,33,51,89,26,27,31,82,44,61,62,75,66,11,93,49,43,85,
        0,87,40,24,29,15,59,16,67,19,72,57,41,8,79,56,4,18,17,84,90,47,25
    ];

    protected $boards = [];

    function __construct($day)
    {
        parent::__construct($day);

        $boardId = 0;
        $max = count($this->data);
        for ($i = 0; $i < $max; $i++) {
            if ($i%5 == 0) {
                $boardId++;
                $this->boards[$boardId] = new Board($boardId);
            }
            $this->boards[$boardId]->addRow($this->data[$i]);
        }
    }

    public function run()
    {
        $boardsCompleted = [];
        $numberOfBoards = count($this->boards);
        foreach ($this->draw as $nr) {
            foreach ($this->boards as $board) {
                if (!isset($boardsCompleted[$board->getId()]) && $board->setDrawnNumber($nr)) {
                    $boardsCompleted[$board->getId()] = $board;
                }
            }
            if ($numberOfBoards == count($boardsCompleted)) {
                break;
            }
        }

        $lastWinningBoard = array_pop($boardsCompleted);

        $this->output('Last winning board: ' . $lastWinningBoard->getId());
        $this->output('Solution: ' . $lastWinningBoard->getSolution($nr), 'green');
    }
}

$obj = new day04a(4);
$obj->run();