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

    public static function convertToUnix($command){
        $command = str_replace("\\", "/", $command);
        $command = str_replace("%CD%", ".", $command);
        $command = str_replace(".exe", "", $command);
        return $command;
    }

    public static function runCommand($command){
        $command = $command . " 2>&1";
        if (!(strtoupper(substr(PHP_OS, 0, 3)) === 'WIN')) {
            $command = CommandLineTools::convertToUnix($command);
        }
        return shell_exec($command);
    }

    public static function RunSOX($args){
        $args = CommandLineTools::SetupArgs($args);
        $path = strtoupper(substr(PHP_OS, 0, 3)) === 'WIN' ? "\"%CD%\\tools\\sox\\sox.exe\"" : "sox";
        return CommandLineTools::runCommand("{$path} {$args}");
    }
    
    public static function RunVGAudio($args){
        $args = CommandLineTools::SetupArgs($args);
        return CommandLineTools::runCommand("dotnet \"%CD%\\tools\\vgaudio\\VGAudioCli.dll\" {$args}");
    }
    
    public static function RunNUS3Audio($args){
        $args = CommandLineTools::SetupArgs($args);
        return CommandLineTools::runCommand("\"%CD%\\tools\\nus3audio\\nus3audio.exe\" {$args}");
    }
    
    public static function RunPyMusicLooper($args){
        $args = CommandLineTools::SetupArgs($args);
        return CommandLineTools::runCommand("pymusiclooper {$args}");
    }

    public static function console_log($message) {
        $STDERR = fopen("php://stderr", "w");
                  fwrite($STDERR, "\n".$message."\n\n");
                  fclose($STDERR);
    }
    
    public static function RunYTDLP($args){
        $args = CommandLineTools::SetupArgs($args);
        return CommandLineTools::runCommand("\"%CD%\\tools\\yt-dlp\\yt-dlp.exe\" {$args}");
    }
    
    public static function RunVGMStream($args){
        $args = CommandLineTools::SetupArgs($args);
        return CommandLineTools::runCommand("\"%CD%\\tools\\vgmstream\\test.exe\" {$args}");
    }
    
    public static function RunPRC2JSON($args){
        $args = CommandLineTools::SetupArgs($args);
        return CommandLineTools::runCommand("dotnet \"%CD%\\tools\\prc2json\\prc2json.dll\" {$args} -l \"%CD%\\tools\\prc2json\\ParamLabels.csv\"");
    }

    public static function RunMSBTEditorCLI($args){
        $args = CommandLineTools::SetupArgs($args);
        return CommandLineTools::runCommand("dotnet \"%CD%\\tools\\MSBTEditorCLI\\MSBTEditorCli.dll\" {$args}");
    }
}

?>