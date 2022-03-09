<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Audio Conversion - Smash Ultimate Tools</title>
    <link rel="stylesheet" href="./css/audio.css">
    <link rel="stylesheet" href="./css/new-front-page.css">
    <link rel="icon" type="image/x-icon" href="./img/tools_favicon.ico">

    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/popper.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
</head>

<body>
    <div class="header-desktop">
        <div class="tab">
        </div>
        <img src="./img/front-page/tools_header.webp" alt="Smash Ultimate Tools" style="width: 100%; cursor: pointer;" onclick="window.location.href = this.getAttribute('data-href')" id="main-header-img" data-href="." />
        <div class="tab">
        </div>
    </div>

    <div class="header-mobile">
        <img src="./img/front-page/tools_header.webp" alt="Smash Ultimate Tools" style="width: 100%; cursor: pointer;" onclick="window.location.href = this.getAttribute('data-href')" id="main-header-img" data-href="." />
    </div>

    <?php
    if (isset($_SESSION["message"])) {
        $status = $_SESSION["message"]["passed"] ? array("text-success", "Success!") : array("text-error", "Error!");
        echo "
            <div class=\"card\">
                <div>
                    <h2 class=\"{$status[0]}\">{$status[1]}</h2>
                    {$_SESSION['message']['message']}
                </div>
            </div>";
        unset($_SESSION["message"]);
    }
    ?>

    <br>
    <div class="container">
        <div class="Left">
            <form method="post" action="./index.php?page=audio" enctype="multipart/form-data">
                <?php
                    if(ALLOW_YOUTUBE){
                        echo '<div class="form-check-input">
                            <input type="checkbox" class="checkbox-rounded" id="youtubeLinkCheck" name="youtubeLinkCheck" onchange="useYouTubeLink(this);">
                            <label for="youtubeLinkCheck">Use YouTube Link</label>
                        </div>
                        <br>';
                    }
                ?>
                <div class="form-file-input" id="musicFileSection">
                    <label for="musicFile">Music File:</label>
                    <input type="file" id="musicFile" name="musicFile" accept="audio/*, .brstm, .lopus, .idsp" onchange="FileInputChanged();">
                    <small class="form-text text-muted">File Size Limit: 100mb</small>
                    <small class="form-text" style="color:red; display:none;" id="fileError">File too big!</small>
                    <br>
                    <small class="form-text" style="color:blue; font-weight: bold;">Supported Formats: Everything SoX
                        natively supports + vgmstream formats + mp3</small>
                    <div id="vgmStreamIndexContainer" style="display: none; margin-top: 10px; margin-bottom: 10px;" class="form-text-input">
                        <label for="vgmStreamIndex">VGMStream Index:</label>
                        <input type="number" step="1" id="vgmStreamIndex" name="vgmStreamIndex" value="0">
                    </div>
                </div>
                <?php
                    if(ALLOW_YOUTUBE){
                        echo '<div id="youtubeLinkSection" style="display: none; margin-top: 10px; margin-bottom: 10px;" class="form-text-input">
                                <label for="youtubeLink">YouTube Link:</label>
                                <input type="text" id="youtubeLink" name="youtubeLink" placeholder="https://www.youtube.com/watch?v=dQw4w9WgXcQ">
                            </div>';
                    }
                ?>
                <div id="type_div" class="form-type-input">
                    <br>
                    <label for="type">Select a file type:</label>
                    <select class="custom-select" id="type" onchange="UpdateType(this)">
                        <option value="nus3audio">nus3audio</option>
                        <option value="lopus">lopus</option>
                        <option value="idsp">idsp</option>
                        <option value="brstm">BRSTM</option>
                        <option value="bfstm">BFSTM</option>
                        <option value="wav">wav</option>
                    </select>
                    <input type="hidden" id="target" name="target">
                </div>
                <br>
                <div class="form-type-input">
                    <div style="display:inline;">
                        <label for="songs" style="display:inline;">Select a song:</label>
                        <a href="javascript:void(0)" style="display:inline; float:right;" id="reset" onclick="resetFilters();">Reset</a>
                        <a href="javascript:void(0)" style="display:inline; float:right; padding-right:2%;" id="more" onclick="displayFilters();">More Options</a>
                    </div>
                    <div id="filters" style="display:none;">
                        <input id="search_box" style="display: none;">
                        <br style="margin-bottom:6px;">
                        <div id="filter"></div>
                    </div>
                    <select class="custom-select" id="songs" onchange="UpdateStage(this)"></select>
                    <h4>Selected File Name: <span id='selected_name'>...</span></h4>
                </div>
        </div>

        <div class="Right">
            <div id="loop_container">
                <div class="form-check-input">
                    <input type="checkbox" class="checkbox-rounded" id="loop" name="loop" onchange="LoopSamples(this);">
                    <label for="loop">Enable Looping</label>
                </div>
                <br>
                <div id="loopSection" style="display: none;">
                    <?php
                        if(ALLOW_PYMUSICLOOPER){
                            echo '<div class="form-check-input">
                                    <input type="checkbox" class="checkbox-rounded" id="pyMusicLooper" name="pyMusicLooper" onchange="togglePyMusicLooper(this);">
                                    <label for="pyMusicLooper">Use pymusiclooper (auto-detect loop samples)</label>
                                    <br />
                                    <br />
                                </div>';
                        }
                    ?>
                    <div id="loopInfo">
                        <div id="loop_hz_options">
                            <div class="form-type-input">
                                <label for="sampleHZ">Samples Rate:</label>
                                <select class="custom-select" id="sampleHZ" name="sampleHZ" onchange="UpdateHZ(this)">
                                    <option value="auto">Auto Detect</option>
                                    <option value="48">48000hz - Smash Ultimate</option>
                                    <option value="441">44100hz - Smash Custom Music / Brstm</option>
                                    <option>Custom hz</option>
                                </select>
                            </div>
                            <div id="sampleHZdiv" style="display: none; margin-top: 10px; margin-bottom: 10px;" class="form-text-input">
                                <label for="srcSampleRate">Sample HZ:</label>
                                <input type="text" id="srcSampleRate" name="srcSampleRate">
                            </div>

                            <div id="loop_samples_select_container" class="form-type-input" style="display: none; margin-top: 10px; margin-bottom: 10px;">
                                <label>Loop Samples:</label>
                                <select class="custom-select" id="loop_samples_select" onchange="UpdateLoopSelect(this)">
                                    <option value="auto">Auto Detect (Reads from file)</option>
                                    <option value="custom">Custom (Input custom loop samples)</option>
                                </select>
                                <input type="text" name="loop_type" id="loop_type" style="display: none;">
                            </div>
                        </div>
                        <div id="loop_samples" style="margin-top: 10px;">
                            <small class="form-text" style="color:orangered; font-weight: bold;">Leave the fields empty to
                                loop full
                                song.</small>
                            <small class="form-text" style="color:red; font-weight: bold;">Use either samples, MM:SS.ms, or
                                SS.ms</small>

                            <div class="form-text-input">
                                <label for="start_loop">Loop Sample Start:</label>
                                <br>
                                <input type="text" id="start_loop" name="start_loop">
                            </div>
                            <br>
                            <div class="form-text-input">
                                <label for="end_loop">Loop Sample End:</label>
                                <br>
                                <input type="text" name="end_loop" id="end_loop">
                            </div>
                        </div>
                    </div>
                </div>
                <br>
            </div>

            <div class="form-check-input">
                <input type="checkbox" class="checkbox-rounded" id="advanced" name="advanced" onchange="AdvancedOptions(this);">
                <label for="advanced">Enable Advanced Options</label>
            </div>
            <br>
            <div id="advancedoptions" style="display: none;">
                <div class="form-text-input">
                    <label for="filenameOutput">Output File Name:</label>
                    <input type="text" id="filenameOutput" name="filenameOutput">
                </div>
                <br>
                <div class="form-text-input">
                    <label for="bitrate">Audio Bitrate (VGAudioCli):</label>
                    <input type="text" id="bitrate" name="bitrate" value="64000">
                </div>
            </div>
            <br>
            <div style="float:right; margin-right: 0;" class="button-parent">
                <button class="tablinks" type="submit">Convert!</button>
            </div>
        </div>
        </form>
        <div class="Extras" style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;">
            <br>
            <hr><br>
            <h2>Extra Stuff:</h2>
            <h4><a href="./index.php?page=nus3audioEditor">Replace nus3audio sound banks with idsps</a></h4>
        </div>
    </div>
    <script src="./js/audio.js"></script>
</body>

</html>