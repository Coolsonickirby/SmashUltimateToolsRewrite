<?php
require_once("./classes/CommandLineTools.php");

class PRC {
    private static $usedNumbers = array();

    public $id = 0;
    public $prcPath = "";

    private static function getRandomID()
    {
        do {
            $id = rand(0, MAX_ID);
        } while (in_array($id, PRC::$usedNumbers));
        array_push(PRC::$usedNumbers, $id);
        return $id;
    }

    public function __construct()
    {
        $this->id = PRC::getRandomID();
    }

    public function initalize($srcPath){
        $this->srcPath = $srcPath;
    }

    public function convert($outputPath){
        $args = array(
            $this->srcPath,
            pathinfo($outputPath, PATHINFO_EXTENSION) == "prc" ? "-a" : "-d",
            "-o",
            $outputPath
        );

        $log = CommandLineTools::RunPRC2JSON($args);

        if(!file_exists($outputPath)){
            return Utils::createMessage(false, $log);
        }

        return Utils::createMessage(true, $outputPath);
    }
}

?>