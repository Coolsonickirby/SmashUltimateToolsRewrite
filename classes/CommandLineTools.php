<?php

class CommandLineTools {
    public static function SetupArgs($args){
        for($i = 0; $i < count($args); $i++){
            if(
                strpos($args[$i], " ") !== false
                && 
                    (substr($args[$i], 0, 1) != '"' 
                        && 
                     substr($args[$i], strlen($args[$i]) - 1, 1) != '"'
                    )
                ){
                $args[$i] = "\"{$args[$i]}\"";
            }
        }

        return implode(" ", $args);
    }

    public static function RunSOX($args){
        $args = CommandLineTools::SetupArgs($args);
        return shell_exec("\"%CD%\\tools\\sox\\sox.exe\" {$args}");
    }
    
    public static function RunVGAudio($args){
        $args = CommandLineTools::SetupArgs($args);
        return shell_exec("\"%CD%\\tools\\vgaudio\\VGAudioCli.exe\" {$args}");
    }
    
    public static function RunNUS3Audio($args){
        $args = CommandLineTools::SetupArgs($args);
        return shell_exec("\"%CD%\\tools\\nus3audio\\nus3audio.exe\" {$args}");
    }
    
    public static function RunPyMusicLooper($args){
        $args = CommandLineTools::SetupArgs($args);
        return shell_exec("pymusiclooper {$args}");
    }
    
    public static function RunYTDLP($args){
        $args = CommandLineTools::SetupArgs($args);
        return shell_exec("\"%CD%\\tools\\yt-dlp\\yt-dlp.exe\" {$args}");
    }
    
    public static function RunVGMStream($args){
        $args = CommandLineTools::SetupArgs($args);
        return shell_exec("\"%CD%\\tools\\vgmstream\\test.exe\" {$args}");
    }
    
    public static function RunPRC2JSON($args){
        $args = CommandLineTools::SetupArgs($args);
        return shell_exec("dotnet \"%CD%\\tools\\prc2json\\prc2json.dll\" {$args} -l \"%CD%\\tools\\prc2json\\ParamLabels.csv\"");
    }

    public static function RunMSBTEditorCLI($args){
        $args = CommandLineTools::SetupArgs($args);
        return shell_exec("dotnet \"%CD%\\tools\\MSBTEditorCLI\\MSBTEditorCli.dll\" {$args}");
    }
}

?>