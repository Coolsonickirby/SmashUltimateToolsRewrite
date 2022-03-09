<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>nus3audio Editor</title>
    <meta name="viewport" content="width=1024">
    <link rel="stylesheet" href="./css/audio.css">
    <link rel="stylesheet" href="./css/new-front-page.css">
    <link rel="stylesheet" href="./css/nus3audio_editor.css">
    <link rel="icon" type="image/x-icon" href="./img/tools_favicon.ico">
    <style>
        .header-mobile {
            grid-template-rows: 1fr !important;
            grid-template-areas: "." !important;
            margin-bottom: 40px !important;
        }

        @media only screen and (max-width:920px) {
            .container {
                width: 60%;
                grid-template-columns: 1fr !important;
                grid-template-rows: 0.5fr 1fr !important;
                gap: 20px 0px !important;
                grid-template-areas:
                    "Left"
                    "Extras" !important;
            }
        }

        .container {
            grid-template-columns: 1fr !important;
            grid-template-rows: 0.5fr 1fr !important;
            grid-template-areas:
                "Left Left"
                "Extras Extras" !important;
        }

        .small {
            width: 25px;
            height: 25px;
            margin: 0;
            margin-bottom: 5px;
        }

        .small>button {
            width: 25px;
            height: 25px;
            min-height: 25px;
        }
    </style>
</head>

<body>

    <div class="header-desktop">
        <div class="tab">
        </div>
        <img src="../img/front-page/tools_header.webp" alt="Smash Ultimate Tools" style="width: 100%; cursor: pointer;" onclick="window.location.href = this.getAttribute('data-href')" id="main-header-img" data-href="./" />
        <div class="tab">
        </div>
    </div>

    <div class="header-mobile">
        <img src="../img/front-page/tools_header.webp" alt="Smash Ultimate Tools" style="width: 100%; cursor: pointer;" onclick="window.location.href = this.getAttribute('data-href')" id="main-header-img" data-href="./" />
    </div>

    <br>

    <div class="container">
        <div class="Left">
            <div id="new-main">
                <div class="buttons">
                    <div class="button-parent">
                        <button class="tablinks" id="open">Open</button>
                        <input type="file" id="file" accept=".nus3audio" hidden>
                    </div>

                    <div class="button-parent">
                        <button class="tablinks" id="save">Save</button>
                    </div>
                </div>
                <div style="text-align: center;">
                    <h1 id="prog">Please open a nus3audio file!</h1>
                </div>
                <br>
                <div id="main-section">
                    <table>
                        <tbody id="main-entries">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="Extras">
            <br>
            <hr>
            <br>
            <h2>Extra Stuff:</h2>
            <h4><a href="/index.php?page=audio">Convert songs</a></h4>
        </div>
    </div>
    
    <script>
        fields_amount = 0;

        function add_field() {
            fields_amount++;

            id = "file_" + fields_amount;

            var new_input = document.createElement("div");

            new_input.innerHTML = `
            <div id="${id}">
                <hr>
                    <div class="button-parent small">
                        <button type="button" class="close" aria-label="Close" onclick="remove_field('${id}')">
                           &times;
                        </button>

                        </div>
                        <div class="form-text-input">
                            <input name="files_id[]" id="files_id_${fields_amount}">
                        </div>
                        <br>
                        <div class="form-file-input">
                            <input type="file" name="files[]" accept=".idsp, .lopus">
                        </div>
                    </div>
            `;

            document.getElementById("files").appendChild(new_input);

            setInputFilter(document.getElementById("files_id_" + fields_amount), function(value) {
                return /^-?\d*$/.test(value);
            });

        }

        function remove_field(elementId) {
            var element = document.getElementById(elementId);
            element.parentNode.removeChild(element);
        }

        /*
            Thanks to the Stackoverflow community wiki
            Source: https://stackoverflow.com/posts/469362/revisions
        */
        function setInputFilter(textbox, inputFilter) {
            ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
                textbox.addEventListener(event, function() {
                    if (inputFilter(this.value)) {
                        this.oldValue = this.value;
                        this.oldSelectionStart = this.selectionStart;
                        this.oldSelectionEnd = this.selectionEnd;
                    } else if (this.hasOwnProperty("oldValue")) {
                        this.value = this.oldValue;
                        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
                    } else {
                        this.value = "";
                    }
                });
            });
        }
    </script>


    <script src="./js/md5.min.js"></script>
    <script src="./js/nus3audio.js"></script>
    <script src="./js/nus3audio_editor.js"></script>
</body>

</html>