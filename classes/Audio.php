<?php
require_once("./classes/CommandLineTools.php");
require_once("./classes/Utils.php");

class Audio
{
    private static $usedNumbers = array();
    // From https://github.com/vgmstream/vgmstream/blob/master/src/formats.c#L21
    private static $vgmstream_extensions = array(
        //"", /* vgmstream can play extensionless files too, but plugins must accept them manually */

        "208",
        "2dx9",
        "2pfs",
        "3do",
        "4", //for Game.com audio
        "8", //txth/reserved [Gungage (PS1)]
        "800",
        "9tav",

        //"aac", //common
        "aa3", //FFmpeg/not parsed (ATRAC3/ATRAC3PLUS/MP3/LPCM/WMA)
        "aax",
        "abc", //txth/reserved [Find My Own Way (PS2) tech demo]
        "abk",
        //"ac3", //common, FFmpeg/not parsed (AC3)
        "acb",
        "acm",
        "acx",
        "ad", //txth/reserved [Xenosaga Freaks (PS2)]
        "adc", //txth/reserved [Tomb Raider The Last Revelation (DC), Tomb Raider Chronicles (DC)]
        "adm",
        "adp",
        "adpcm",
        "adpcmx",
        "ads",
        "adw",
        "adx",
        "afc",
        "afs2",
        "agsc",
        "ahx",
        "ahv",
        "ai",
        //"aif", //common
        "aif-Loop",
        "aifc", //common?
        //"aiff", //common
        "aix",
        "akb",
        "al",
        "al2",
        "ams", //txth/reserved [Super Dragon Ball Z (PS2) ELF names]
        "amts", //fake extension/header id for .stm (renamed? to be removed?)
        "an2",
        "ao",
        "ap",
        "apc",
        "as4",
        "asd",
        "asf",
        "asr",
        "ass",
        "ast",
        "at3",
        "at9",
        "atsl",
        "atsl3",
        "atsl4",
        "atx",
        "aud",
        "audio", //txth/reserved [Grimm Echoes (Android)]
        "aus",
        "awa", //txth/reserved [Missing Parts Side A (PS2)]
        "awb",
        "awc",

        "b1s",
        "baf",
        "baka",
        "bank",
        "bar",
        "bcstm",
        "bcwav",
        "bd3",
        "bdsp",
        "bfstm",
        "bfwav",
        "bg00",
        "bgm",
        "bgw",
        "bh2pcm",
        "bik",
        "bika", //fake extension for .bik (to be removed)
        "bik2",
        //"bin", //common
        "bk2",
        "blk",
        "bmdx",
        "bms",
        "bnk",
        "bnm",
        "bns",
        "bnsf",
        "bo2",
        "brstm",
        "brstmspm",
        "bsnd",
        "btsnd",
        "bvg",
        "bwav",

        "caf",
        "capdsp",
        "cbd2",
        "ccc",
        "cd",
        "cfn", //fake extension for CAF (renamed, to be removed?)
        "chk",
        "ckb",
        "ckd",
        "cks",
        "cnk",
        "cpk",
        "cps",
        "csa", //txth/reserved [LEGO Racers 2 (PS2)]
        "csmp",
        "cvs", //txth/reserved [Aladdin in Nasira's Revenge (PS1)]
        "cwav",
        "cxs",

        "d2", //txth/reserved [Dodonpachi Dai-Ou-Jou (PS2)]
        "da",
        //"dat", //common
        "data",
        "dax",
        "dbm",
        "dct",
        "dcs",
        "ddsp",
        "de2",
        "dec",
        "diva",
        "dmsg", //fake extension/header id for .sgt (to be removed)
        "ds2", //txth/reserved [Star Wars Bounty Hunter (GC)]
        "dsb",
        "dsf",
        "dsp",
        "dspw",
        "dtk",
        "dvi",
        "dxh",
        "dyx", //txth/reserved [Shrek 4 (iOS)]

        "e4x",
        "eam",
        "eas",
        "eda", //txth/reserved [Project Eden (PS2)]
        "emff", //fake extension for .mul (to be removed)
        "enm",
        "eno",
        "ens",
        "exa",
        "ezw",

        "fag",
        "fda",
        "ffw",
        "filp",
        //"flac", //common
        "flx",
        "fsb",
        "fsv",
        "fwav",
        "fwse",

        "g1l",
        "gbts",
        "gca",
        "gcm",
        "gcub",
        "gcw",
        "genh",
        "gin",
        "gms",
        "grn",
        "gsb",
        "gsf",
        "gtd",
        "gwm",

        "h4m",
        "hab",
        "hca",
        "hdr",
        "hgc1",
        "his",
        "hps",
        "hsf",
        "hwx", //txth/reserved [Star Wars Episode III (Xbox)]
        "hx2",
        "hx3",
        "hxc",
        "hxd",
        "hxg",
        "hxx",
        "hwas",

        "iab",
        "iadp",
        "idmsf",
        "idsp",
        "idvi", //fake extension/header id for .pcm (renamed, to be removed)
        "idwav",
        "idx",
        "idxma",
        "ifs",
        "ikm",
        "ild",
        "ilv", //txth/reserved [Star Wars Episode III (PS2)]
        "ima",
        "imc",
        "imx",
        "int",
        "is14",
        "isb",
        "isd",
        "isws",
        "itl",
        "ivaud",
        "ivag",
        "ivb",
        "ivs", //txth/reserved [Burnout 2 (PS2)]

        "joe",
        "jstm",

        "kat",
        "kces",
        "kcey", //fake extension/header id for .pcm (renamed, to be removed)
        "km9",
        "kovs", //fake extension/header id for .kvs
        "kno",
        "kns",
        "koe",
        "kraw",
        "ktac",
        "ktsl2asbin",
        "ktss", //fake extension/header id for .kns
        "kvs",
        "kwa",

        "l",
        "l00", //txth/reserved [Disney's Dinosaur (PS2)]
        "laac", //fake extension for .aac (tri-Ace)
        "ladpcm", //not fake
        "laif", //fake extension for .aif (various)
        "laiff", //fake extension for .aiff
        "laifc", //fake extension for .aifc
        "lac3", //fake extension for .ac3, FFmpeg/not parsed
        "lasf", //fake extension for .asf (various)
        "lbin", //fake extension for .bin (various)
        "leg",
        "lep",
        "lflac", //fake extension for .flac, FFmpeg/not parsed
        "lin",
        "lm0",
        "lm1",
        "lm2",
        "lm3",
        "lm4",
        "lm5",
        "lm6",
        "lm7",
        "lmp2", //fake extension for .mp2, FFmpeg/not parsed
        "lmp3", //fake extension for .mp3, FFmpeg/not parsed
        "lmp4", //fake extension for .mp4
        "lmpc", //fake extension for .mpc, FFmpeg/not parsed
        "logg", //fake extension for .ogg
        "lopus", //fake extension for .opus, used by LOPU too
        "lp",
        "lpcm",
        "lpk",
        "lps",
        "lrmb",
        "lse",
        "lsf",
        "lstm", //fake extension for .stm
        "lwav", //fake extension for .wav
        "lwma", //fake extension for .wma, FFmpeg/not parsed

        "mab",
        "mad",
        "map",
        "matx",
        "mc3",
        "mca",
        "mcadpcm",
        "mcg",
        "mds",
        "mdsp",
        "med",
        "mjb",
        "mi4", //fake extension for .mib (renamed, to be removed)
        "mib",
        "mic",
        "mihb",
        "mnstr",
        "mogg",
        //"m4a", //common
        //"m4v", //common
        //"mp+", //common [Moonshine Runners (PC)]
        //"mp2", //common
        //"mp3", //common
        //"mp4", //common
        //"mpc", //common
        "mpdsp",
        "mpds",
        "mpf",
        "mps", //txth/reserved [Scandal (PS2)]
        "ms",
        "msa",
        "msb",
        "msd",
        "mse",
        "msf",
        "mss",
        "msv",
        "msvp", //fake extension/header id for .msv
        "mta2",
        "mtaf",
        "mul",
        "mups",
        "mus",
        "musc",
        "musx",
        "mvb", //txth/reserved [Porsche Challenge (PS1)]
        "mwa", //txth/reserved [Fatal Frame (Xbox)]
        "mwv",
        "mxst",
        "myspd",

        "n64",
        "naac",
        "nds",
        "ndp", //fake extension/header id for .nds
        "nlsd",
        "nop",
        "nps",
        "npsf", //fake extension/header id for .nps (in bigfiles)
        "nsa",
        "nsopus",
        "nub",
        "nub2",
        "nus3audio",
        "nus3bank",
        "nwa",
        "nwav",
        "nxa",

        //"ogg", //common
        "ogg_",
        "ogl",
        "ogv",
        "oma", //FFmpeg/not parsed (ATRAC3/ATRAC3PLUS/MP3/LPCM/WMA)
        "omu",
        "opus", //common
        "opusx",
        "otm",
        "oto", //txth/reserved [Vampire Savior (SAT)]
        "ovb",

        "p04", //txth/reserved [Psychic Force 2012 (DC), Skies of Arcadia (DC)]
        "p16", //txth/reserved [Astal (SAT)]
        "p1d", //txth/reserved [Farming Simulator 18 (3DS)]
        "p2a", //txth/reserved [Thunderhawk Operation Phoenix (PS2)]
        "p2bt",
        "p3d",
        "past",
        "pcm",
        "pdt",
        "pk",
        "pnb",
        "pona",
        "pos",
        "ps2stm", //fake extension for .stm (renamed? to be removed?)
        "psb",
        "psf",
        "psh", //fake extension for .vsv (to be removed)
        "psnd",

        "r",
        "rac", //txth/reserved [Manhunt (Xbox)]
        "rad",
        "rak",
        "ras",
        "raw", //txth/reserved [Madden NHL 97 (PC)-pcm8u]
        "rda", //FFmpeg/reserved [Rhythm Destruction (PC)]
        "res", //txth/reserved [Spider-Man: Web of Shadows (PSP)]
        "rkv",
        "rnd",
        "rof",
        "rpgmvo",
        "rrds",
        "rsd",
        "rsf",
        "rsm",
        "rsp",
        "rstm", //fake extension/header id for .rstm (in bigfiles)
        "rvws",
        "rwar",
        "rwav",
        "rws",
        "rwsd",
        "rwx",
        "rxw",
        "rxx", //txth/reserved [Full Auto (X360)]

        "s14",
        "s3v", //txth/reserved [Sound Voltex 5 (AC)]
        "sab",
        "sad",
        "saf",
        "sam", //txth/reserved [Lost Kingdoms 2 (GC)]
        "sap",
        "sb0",
        "sb1",
        "sb2",
        "sb3",
        "sb4",
        "sb5",
        "sb6",
        "sb7",
        "sbk",
        "sbin",
        "sbr",
        "sbv",
        "sm0",
        "sm1",
        "sm2",
        "sm3",
        "sm4",
        "sm5",
        "sm6",
        "sm7",
        "sc",
        "scd",
        "sch",
        "sd9",
        "sdf",
        "sdt",
        "seb",
        "sed",
        "seg",
        "sem", //txth/reserved [Oretachi Game Center Zoku: Sonic Wings (PS2)]
        "sf0",
        "sfl",
        "sfs",
        "sfx",
        "sgb",
        "sgd",
        "sgt",
        "sgx",
        "sl3",
        "slb", //txth/reserved [THE Nekomura no Hitobito (PS2)]
        "sli",
        "smc",
        "smk",
        "smp",
        "smpl", //fake extension/header id for .v0/v1 (renamed, to be removed)
        "smv",
        "snd",
        "snds",
        "sng",
        "sngw",
        "snr",
        "sns",
        "snu",
        "snz", //txth/reserved [Killzone HD (PS3)]
        "sod",
        "son",
        "spd",
        "spm",
        "sps",
        "spsd",
        "spw",
        "ss2",
        "ssd", //txth/reserved [Zack & Wiki (Wii)]
        "ssm",
        "sspr",
        "sss",
        "ster",
        "sth",
        "stm",
        "stma", //fake extension/header id for .stm
        "str",
        "stream",
        "strm",
        "sts",
        "sts_cp3",
        "stx",
        "svag",
        "svs",
        "svg",
        "swag",
        "swav",
        "swd",
        "switch_audio",
        "sx",
        "sxd",
        "sxd2",
        "sxd3",

        "tad",
        "tec",
        "tgq",
        "tgv",
        "thp",
        "tk5",
        "tmx",
        "tra",
        "tun",
        "txth",
        "txtp",
        "tydsp",

        "u0",
        "ue4opus",
        "ulw",
        "um3",
        "utk",
        "uv",

        "v0",
        //"v1", //dual channel with v0
        "va3",
        "vag",
        "vai",
        "vam", //txth/reserved [Rocket Power: Beach Bandits (PS2)]
        "vas",
        "vawx",
        "vb",
        "vbk",
        "vbx", //txth/reserved [THE Taxi 2 (PS2)]
        "vds",
        "vdm",
        "vgi", //txth/reserved [Time Crisis II (PS2)]
        "vgm", //txth/reserved [Maximo (PS2)]
        "vgs",
        "vgv",
        "vid",
        "vig",
        "vis",
        "vms",
        "vmu", //txth/reserved [Red Faction (PS2)]
        "voi",
        "vp6",
        "vpk",
        "vs",
        "vsf",
        "vsv",
        "vxn",

        "w",
        "waa",
        "wac",
        "wad",
        "waf",
        "wam",
        "was",
        //"wav", //common
        "wavc",
        "wave",
        "wavebatch",
        "wavm",
        "wavx", //txth/reserved [LEGO Star Wars (Xbox)]
        "way",
        "wb",
        "wb2",
        "wbd",
        "wbk",
        "wd",
        "wem",
        "wii",
        "wic", //txth/reserved [Road Rash (SAT)-videos]
        "wip", //txth/reserved [Colin McRae DiRT (PC)]
        "wlv", //txth/reserved [ToeJam & Earl III: Mission to Earth (DC)]
        "wmus", //fake extension (to be removed)
        "wp2",
        "wpd",
        "wsd",
        "wsi",
        "wst", //txth/reserved [3jigen Shoujo o Hogo Shimashita (PC)]
        "wua",
        "wv2",
        "wv6",
        "wve",
        "wvs",
        "wvx",
        "wxd",

        "x",
        "x360audio", //fake extension for Unreal Engine 3 XMA (real extension unknown)
        "xa",
        "xa2",
        "xa30",
        "xag", //txth/reserved [Tamsoft's PS2 games]
        "xau",
        "xav",
        "xb", //txth/reserved [Scooby-Doo! Unmasked (Xbox)]
        "xen",
        "xma",
        "xma2",
        "xmu",
        "xmv",
        "xnb",
        "xsh",
        "xsf",
        "xse",
        "xsew",
        "xss",
        "xvag",
        "xvas",
        "xwav", //fake extension for .wav (renamed, to be removed)
        "xwb",
        "xmd",
        "xopus",
        "xps",
        "xwc",
        "xwm",
        "xwma",
        "xws",
        "xwv",

        "ydsp",
        "ymf",

        "zic",
        "zsd",
        "zsm",
        "zss",
        "zwdsp",
        "zwv",

        "vgmstream" /* fake extension, catch-all for FFmpeg/txth/etc */
        //, NULL //end mark
    );


    public $id = 0;
    public $audioPath = "";

    public $sampleRate = 0;
    public $duration = 0;
    public $channels = 0;
    public $format = "";

    public $loop = false;
    public $loopStart = 0;
    public $loopEnd = 0;
    public $loopSampleRate = 0;
    public $usePyMusicLooper = false;
    public $useVGMStreamLoopInfo = false;
    public $vgmStreamIndex = 0;

    private static function getRandomID()
    {
        do {
            $id = rand(0, MAX_ID);
        } while (in_array($id, Audio::$usedNumbers));
        array_push(Audio::$usedNumbers, $id);
        return $id;
    }

    private static function timeToSamples($time, $sample_rate)
    {
        if (strpos($time, ':') != true) {
            $time = "0:" . $time;
        }
        $time_mm = intval(explode(':', $time)[0]);
        $time_ss_ms = floatval(explode(':', $time)[1]);
        $time_converted = ($time_mm * 60) + $time_ss_ms;
        $converted_time = floatval($time_converted) * intval($sample_rate);
        return $converted_time;
    }

    private function getAudioInformation()
    {
        $info = CommandLineTools::RunSOX(array("--i", "{$this->audioPath}"));

        preg_match("/(?<=Sample Rate    : )(.*)(?=\n)/", $info, $tmp);
        
        if(count($tmp) <= 0){
            return Utils::createMessage(false, $info);
        }
        
        $this->sampleRate = intval($tmp[0]);
        
        preg_match("/(?<== )(.*)(?= samples)/", $info, $tmp);
        if(count($tmp) <= 0){
            return Utils::createMessage(false, $info);
        }
        $this->duration = intval($tmp[0]);
        
        preg_match("/(?<=Channels       : )(.*)(?=\n)/", $info, $tmp);
        if(count($tmp) <= 0){
            return Utils::createMessage(false, $info);
        }
        $this->channels = intval($tmp[0]);

        $this->format = pathinfo($this->audioPath, PATHINFO_EXTENSION);

        return Utils::createMessage(true, array(
            "sampleRate" => $this->sampleRate,
            "duration" => $this->duration,
            "channels" => $this->channels,
            "format" => $this->format
        ));
    }

    public function convertFromVGMStream($outputPath, $useVGMStreamInfo)
    {
        $log = CommandLineTools::RunVGMStream(array(
            "-o",
            $outputPath,
            "-i",
            "-s",
            $this->vgmStreamIndex,
            $this->audioPath
        ));

        if(!file_exists($outputPath)){
            return Utils::createMessage(false, $log);
        }

        if($this->useVGMStreamLoopInfo){
            preg_match("/(?<=loop start: )(.*)(?= samples)/", $log, $tmp);
            $this->loopStart = isset($tmp[0]) ? intval($tmp[0]) : $this->loopStart;
    
            preg_match("/(?<=loop end: )(.*)(?= samples)/", $log, $tmp);
            $this->loopEnd = isset($tmp[0]) ? intval($tmp[0]) : $this->loopEnd;
        }

        if ($useVGMStreamInfo) {
            preg_match("/(?<=sample rate: )(.*)(?= Hz)/", $log, $tmp);
            $this->sampleRate = isset($tmp[0]) ? intval($tmp[0]) : $this->sampleRate;

            preg_match("/(?<=channels: )(.*)(?=\n)/", $log, $tmp);
            $this->channels = isset($tmp[0]) ? intval($tmp[0]) : $this->channels;
        }

        $this->format = "wav";

        return Utils::createMessage(true, $outputPath);
    }

    public static function convertToWAV($inputPath, $outputPath, $sampleRate = 48000)
    {
        $log = CommandLineTools::RunSOX(
            array(
                $inputPath,
                "-r",
                $sampleRate,
                "-b",
                16,
                "-c",
                2,
                $outputPath
            )
        );

        if(!file_exists($outputPath)){
            return Utils::createMessage(false, $log);
        }

        return Utils::createMessage(true, $outputPath);
    }

    public function handleLoop(){
        if(!is_numeric($this->loopStart)){
            $this->loopStart = 0;
        }

        if(!is_numeric($this->loopEnd)){
            $this->loopEnd = 0;
        }

        if ($this->loop && $this->usePyMusicLooper) { // Loop based on pymusiclooper
            $log = $this->findLoopPoints();
            if(isset($log["passed"]) && !$log["passed"]){
                return $log;
            }
        } else if ($this->loop && $this->loopEnd <= 0) { // Loop E -> S if loopEnd is equal or below 0 and looping is enabled
            $this->loopEnd = $this->duration;
        }

        if (($this->sampleRate != 48000 || $this->loopSampleRate != 0) && $this->loop) {
            $this->recalculateLoopSamples($this->loopSampleRate != 0 ? $this->loopSampleRate : $this->sampleRate, 48000);
        }
    }

    public function createLopus($outputPath, $bitrate)
    {
        $outputPath = str_replace("{id}", $this->id, $outputPath);

        $originalPath = $this->audioPath;

        // Convert to WAV if any one of the requirements are not met
        if ($this->format != "wav" || $this->sampleRate != 48000 || $this->channels > 2) {
            @mkdir("./tmp/wav/", 0777, true);
            $wavLog = Audio::convertToWAV($this->audioPath, "./tmp/wav/{$this->id}.wav", 48000);
            if(!$wavLog["passed"]){
                return $wavLog;
            }

            $this->audioPath = $wavLog["message"];
        }

        $log = $this->handleLoop();
        if(isset($log["passed"]) && !$log["passed"]){
            return $log;
        }

        $lopusArgs = array();

        if ($this->loop) {
            array_push(
                $lopusArgs,
                "-l",
                "{$this->loopStart}-{$this->loopEnd}"
            );
        }

        array_push($lopusArgs, "--bitrate", "\"{$bitrate}\"", "--CBR", "--opusheader", "namco");

        Utils::createPathWithoutFilename($outputPath);

        $log = CommandLineTools::RunVGAudio(array_merge(array("-i", $this->audioPath, "-o", $outputPath), $lopusArgs));
        $this->audioPath = $originalPath;

        if(!file_exists($outputPath)){
            return Utils::createMessage(false, $log);
        }

        return Utils::createMessage(true, $outputPath);
    }

    public function createGeneric($outputPath, $bitrate)
    {
        $outputPath = str_replace("{id}", $this->id, $outputPath);
        $originalPath = $this->audioPath;

        // Convert to WAV if any one of the requirements are not met
        if ($this->format != "wav" || $this->channels > 2) {
            @mkdir("./tmp/wav/", 0777, true);
            $wavLog = Audio::convertToWAV($this->audioPath, "./tmp/wav/{$this->id}.wav", 48000);
            if(!$wavLog["passed"]){
                return $wavLog;
            }

            $this->audioPath = $wavLog["message"];
        }
        $log = $this->handleLoop();
        if(isset($log["passed"]) && !$log["passed"]){
            return $log;
        }
        $genericArgs = array();

        if ($this->loop) {
            array_push(
                $genericArgs,
                "-l",
                "{$this->loopStart}-{$this->loopEnd}"
            );
        }

        array_push($genericArgs, "--bitrate", "\"{$bitrate}\"");

        Utils::createPathWithoutFilename($outputPath);

        $log = CommandLineTools::RunVGAudio(array_merge(array("-i", $this->audioPath, "-o", $outputPath), $genericArgs));
        $this->audioPath = $originalPath;

        if(!file_exists($outputPath)){
            return Utils::createMessage(false, $log);
        }

        return Utils::createMessage(true, $outputPath);
    }

    private function recalculateLoopSamples($srcHz, $targetHz)
    {
        $resHz = floatval($targetHz) / floatval($srcHz);

        $this->loopStart = intval($this->loopStart * $resHz);
        $this->loopEnd = intval($this->loopEnd * $resHz);
    }

    public function findLoopPoints()
    {
        $loops = CommandLineTools::RunPyMusicLooper(array("--stdout", $this->audioPath));
        preg_match("/\d+ \d+/", $loops, $tmp);
        if(count($tmp) <= 0){
            return Utils::createMessage(false, $loops);
        }
        $loops = trim($loops);
        $loops = explode(" ", $loops);
        $this->loopStart = intval($loops[0]);
        $this->loopEnd = intval($loops[1]);
    }

    public function createNUS3AUDIO($outputPath, $name, $bitrate)
    {
        $outputPath = str_replace("{id}", $this->id, $outputPath);
        $originalPath = $this->audioPath;
        $lopusLog = $this->createLopus("./tmp/lopus/{id}.lopus", $bitrate);
        
        if(!$lopusLog["passed"]){
            return $lopusLog;
        }

        $this->audioPath = $lopusLog["message"];
        
        Utils::createPathWithoutFilename($outputPath);

        $nus3audioArgs = array(
            "-n",
            "-A",
            $name,
            $this->audioPath,
            "-w",
            $outputPath
        );

        $log = CommandLineTools::RunNUS3Audio($nus3audioArgs);
        $this->audioPath = $originalPath;

        if(!file_exists($outputPath)){
            return Utils::createMessage(false, $log);
        }

        return Utils::createMessage(true, $outputPath);
    }

    public function __construct()
    {
        $this->id = Audio::getRandomID();
    }

    public function initalize($audioPath, $loopStart = 0, $loopEnd = 0, $loopSampleRate = 48000)
    {
        $this->audioPath = $audioPath;

        // Assume it's a YT Link if audioPath starts with HTTP
        if (substr($this->audioPath, 0, 4) === "http") {
            $outputPath = "./tmp/yt/{$this->id}.mp3";
            $ytDLPArgs = array(
                "-x",
                "--audio-format",
                "mp3",
                "-o",
                $outputPath,
                $this->audioPath
            );

            $log = CommandLineTools::RunYTDLP($ytDLPArgs);

            if(!file_exists($outputPath)){
                return Utils::createMessage(false, $log);
            }

            $this->audioPath = $outputPath;
        }

        $this->loopStart = $loopStart;
        $this->loopEnd = $loopEnd;
        $this->loopSampleRate = $loopSampleRate === "auto" ? 0 : intval($loopSampleRate);

        $extension = pathinfo($this->audioPath, PATHINFO_EXTENSION);

        if (in_array($extension, Audio::$vgmstream_extensions)) {
            $outputPath = "./tmp/vgmstream/{$this->id}.wav";
            Utils::createPathWithoutFilename($outputPath);
            $vgmLog = $this->convertFromVGMStream($outputPath, true);
            if($vgmLog["passed"]){
                $this->audioPath = $vgmLog["message"];
            }
        } else {
            $this->getAudioInformation();
        }

        if (strpos($this->loopStart, ":") !== false || strpos($this->loopStart, ".") !== false) {
            $this->loopStart = Audio::timeToSamples($this->loopStart, $this->loopSampleRate != 0 ? $this->loopSampleRate : $this->sampleRate);
        }
        if (strpos($this->loopEnd, ":") !== false || strpos($this->loopEnd, ".") !== false) {
            $this->loopEnd = Audio::timeToSamples($this->loopEnd, $this->loopSampleRate != 0 ? $this->loopSampleRate : $this->sampleRate);
        }
    }
}
