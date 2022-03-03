<?php

class ApiController {
    static function handle(){
        $pageMethod = "";

        if (!isset($_GET["function"]) || $_GET["function"] === 'home') {
            include("./pages/home.php");
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pageMethod = "post" . ucfirst($_GET["function"]);
        } else if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $pageMethod = "get" . ucfirst($_GET["function"]);
        } else {
            return;
        }

        if (method_exists(__CLASS__, $pageMethod)) {
            ApiController::$pageMethod();
        }
    }

    static function getLoadPRC(){
        if(!isset($_GET["id"])){ echo "failed"; return; }

        $id = intval($_GET["id"]) != 0 ? intval($_GET["id"]) : 0;

        if($id > 0){
            $path = "./out/prcs/{$id}/out.json";
        }else {
            $path = "./defaults/{$_GET['id']}.json";
        }

        $json = file_get_contents($path);

        echo $json;
    }
    
    static function getLoadMSBT(){
        if(!isset($_GET["id"])){ echo "failed"; return; }

        $id = intval($_GET["id"]) != 0 ? intval($_GET["id"]) : 0;

        if($id > 0){
            $path = "./out/msbts/{$id}/out.json";
        }else {
            echo "";
            return;
        }

        $json = file_get_contents($path);

        echo $json;
    }
}

?>