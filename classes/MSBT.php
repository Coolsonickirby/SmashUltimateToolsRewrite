<?php
require_once("./classes/CommandLineTools.php");

class MSBT {
    private static $usedNumbers = array();

    public $id = 0;
    public $prcPath = "";

    private static function getRandomID()
    {
        do {
            $id = rand(0, MAX_ID);
        } while (in_array($id, MSBT::$usedNumbers));
        array_push(MSBT::$usedNumbers, $id);
        return $id;
    }

    public function __construct()
    {
        $this->id = MSBT::getRandomID();
    }

    public function initalize($srcPath){
        $this->srcPath = $srcPath;
    }

    public function convert($outputPath){
        $args = array(
            $this->srcPath,
            $outputPath
        );
        
        CommandLineTools::RunMSBTEditorCLI($args);

        return $outputPath;
    }
}
