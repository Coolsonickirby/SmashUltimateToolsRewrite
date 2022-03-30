<?php

class Utils {
    public static function createPathWithoutFilename($path){
        $path_parts = pathinfo($path);
        @mkdir($path_parts['dirname'], 0777, true);
    }

    public static function createMessage($passed, $message){
        return array("passed" => $passed, "message" => $message);
    }
}

?>