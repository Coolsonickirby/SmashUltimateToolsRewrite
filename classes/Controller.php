<?php
require_once("./classes/Audio.php");
require_once("./classes/PRC.php");
require_once("./classes/MSBT.php");

class Controller {

    static function redirect($path){
        header("Location: {$path}");
        die();
    }

    static function handle(){
        $pageMethod = "";

        if(!isset($_GET["page"]) || $_GET["page"] === 'home'){
            include("./pages/home.php");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pageMethod = "post" . ucfirst($_GET["page"]);
        }else if($_SERVER['REQUEST_METHOD'] === 'GET'){
            $pageMethod = "get" . ucfirst($_GET["page"]);
        }else {
            return;
        }

        if(method_exists(__CLASS__, $pageMethod)){
            Controller::$pageMethod();
        }else if(file_exists("pages/{$_GET["page"]}.php")){
            include("./pages/{$_GET["page"]}.php");
            return;
        }
    }

    #region Audio Section
    static function getNus3audioEditor(){
        include("./pages/nus3audioEditor.php");
        return true;
    }

    static function getAudio(){
        include("./pages/audioPage.php");
        return true;
    }

    static function postAudio(){
        if(isset($_POST["target"])){
            $audio = new Audio();

            $audio->loop = isset($_POST["loop"]) && $_POST["loop"] === 'on';
            $audio->useVGMStreamLoopInfo = $_POST["loop_type"] === "auto";
            $audio->usePyMusicLooper = isset($_POST["pyMusicLooper"]) && $_POST["pyMusicLooper"] === 'on' && ALLOW_PYMUSICLOOPER;
            $audio->vgmStreamIndex = isset($_POST["vgmStreamIndex"]) ? $_POST["vgmStreamIndex"] : 0;

            $loopSampleRate = $_POST["srcSampleRate"] === 'auto' ? 0 : intval($_POST["srcSampleRate"]);
            $loopStart = $_POST["start_loop"];
            $loopEnd = $_POST["end_loop"];

            $targetPath = "";
            $ext = "";

            if(isset($_POST["youtubeLinkCheck"]) && $_POST["youtubeLinkCheck"] === 'on' && ALLOW_YOUTUBE){
                $targetPath = $_POST["youtubeLink"];
                $ext = "YouTube";
                set_time_limit(300);
            } else {
                $targetPath = "./tmp/uploads/{$audio->id}/" . basename($_FILES["musicFile"]["name"]);
                $ext = strtolower(pathinfo($targetPath, PATHINFO_EXTENSION));
                Utils::createPathWithoutFilename($targetPath);

                if (!move_uploaded_file($_FILES["musicFile"]["tmp_name"], $targetPath)) {
                    $_SESSION["message"] = array(
                        "passed" => false,
                        "message" => "<p class=\"card-text\">Failed to upload file!</p>"
                    );
                    Controller::redirect("./index.php?page=audio");
                    die();
                };
            }

            $audio->initalize($targetPath, $loopStart, $loopEnd, $loopSampleRate);

            $outputPath = "{$_POST['filenameOutput']}";
            $bitrate = intval($_POST["bitrate"]);

            if ($_POST["target"] === 'nus3audio') {
                $outputPath = "./out/nus3audio/{id}/{$outputPath}.nus3audio";
                $result = $audio->createNUS3AUDIO($outputPath, "SmashUltimateTools (Converted from {$ext})", $bitrate);
                $_SESSION["message"] = array(
                    "passed" => true,
                    "message" => "<p class=\"card-text\">nus3audio Conversion Complete! You can download it from <a class=\"return_link\" href=\"{$result}\">here!</a></p>"
                );
            } else if ($_POST["target"] === 'lopus') {
                $outputPath = "./out/lopus/{id}/{$outputPath}.lopus";
                $result = $audio->createLopus($outputPath, $bitrate);
                $_SESSION["message"] = array(
                    "passed" => true,
                    "message" => "<p class=\"card-text\">lopus Conversion Complete! You can download it from <a class=\"return_link\" href=\"{$result}\">here!</a></p>"
                );
            } else if ($_POST["target"] === 'idsp') {
                $outputPath = "./out/idsp/{id}/{$outputPath}.idsp";
                $result = $audio->createGeneric($outputPath, $bitrate);
                $_SESSION["message"] = array(
                    "passed" => true,
                    "message" => "<p class=\"card-text\">IDSP Conversion Complete! You can download it from <a class=\"return_link\" href=\"{$result}\">here!</a></p>"
                );
            } else if ($_POST["target"] === 'brstm'){
                $outputPath = "./out/brstm/{id}/{$outputPath}.brstm";
                $result = $audio->createGeneric($outputPath, $bitrate);
                $_SESSION["message"] = array(
                    "passed" => true,
                    "message" => "<p class=\"card-text\">BRSTM Conversion Complete! You can download it from <a class=\"return_link\" href=\"{$result}\">here!</a></p>"
                );
            } else if ($_POST["target"] === 'bfstm'){
                $outputPath = "./out/bfstm/{id}/{$outputPath}.bfstm";
                $result = $audio->createGeneric($outputPath, $bitrate);
                $_SESSION["message"] = array(
                    "passed" => true,
                    "message" => "<p class=\"card-text\">BFSTM Conversion Complete! You can download it from <a class=\"return_link\" href=\"{$result}\">here!</a></p>"
                );
            } else if ($_POST["target"] === 'wav'){
                $outputPath = "./out/wav/{id}/{$outputPath}.wav";
                $result = Audio::convertToWAV($outputPath, $audio->audioPath);
                $_SESSION["message"] = array(
                    "passed" => true,
                    "message" => "<p class=\"card-text\">wav Conversion Complete! You can download it from <a class=\"return_link\" href=\"{$result}\">here!</a></p>"
                );
            }
        }
        Controller::redirect("./index.php?page=audio");
    }
    #endregion

    static function getPrcChara(){
        include("./pages/prcChara.php");
        return;
    }

    static function postOpenPRC(){
        $prc = new PRC();
        $targetPath = "./tmp/prcs/{$prc->id}/out.prc";
        Utils::createPathWithoutFilename($targetPath);
        
        if (!move_uploaded_file($_FILES["fileInput"]["tmp_name"], $targetPath)) {
            $_SESSION["message"] = array(
                "passed" => false,
                "message" => "<p class=\"card-text\">Failed to upload file!</p>"
            );
            Controller::redirect("./index.php");
        };

        $outPath = "./out/prcs/{$prc->id}/out.json";
        Utils::createPathWithoutFilename($outPath);

        $prc->initalize($targetPath);
        $prc->convert($outPath);
        Controller::redirect("./index.php?page={$_GET['source']}&id={$prc->id}");
    }
    
    static function postSavePRC(){
        $prc = new PRC();
        $targetPath = "./tmp/prcs/{$prc->id}/out.json";
        Utils::createPathWithoutFilename($targetPath);

        file_put_contents($targetPath, $_POST["json"]);

        $outPath = "./out/prcs/{$prc->id}/out.prc";
        Utils::createPathWithoutFilename($outPath);

        $prc->initalize($targetPath);
        $prc->convert($outPath);

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"{$_GET['outputName']}\"");
        readfile($outPath);
    }

    static function postOpenMSBT(){
        $msbt = new MSBT();
        $targetPath = "./tmp/msbts/{$msbt->id}/out.msbt";
        Utils::createPathWithoutFilename($targetPath);

        if (!move_uploaded_file($_FILES["fileInput"]["tmp_name"], $targetPath)) {
            $_SESSION["message"] = array(
                "passed" => false,
                "message" => "<p class=\"card-text\">Failed to upload file!</p>"
            );
            Controller::redirect("./index.php");
        };

        $outPath = "./out/msbts/{$msbt->id}/out.json";
        Utils::createPathWithoutFilename($outPath);

        $msbt->initalize($targetPath);
        $msbt->convert($outPath);
        Controller::redirect("./index.php?page={$_GET['source']}&id={$msbt->id}&outputName=" . basename($_FILES["fileInput"]["name"]));
    }

    static function postSaveMSBT()
    {
        $msbt = new MSBT();
        $targetPath = "./tmp/msbts/{$msbt->id}/out.json";
        Utils::createPathWithoutFilename($targetPath);

        file_put_contents($targetPath, $_POST["json"]);

        $outPath = "./out/msbts/{$msbt->id}/out.msbt";
        Utils::createPathWithoutFilename($outPath);

        $msbt->initalize($targetPath);
        $msbt->convert($outPath);

        header('Content-Type: application/octet-stream');
        header("Content-Transfer-Encoding: Binary");
        header("Content-disposition: attachment; filename=\"{$_GET['outputName']}\"");
        readfile($outPath);
    }
}


?>