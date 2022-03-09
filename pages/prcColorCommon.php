<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Common Color Editor</title>
    <meta name="viewport" content="width=1024">
    <link rel="stylesheet" href="./css/new-front-page.css">
    <link rel="stylesheet" href="./css/prcColorCommon.css">
    <link rel="icon" type="image/x-icon" href="./img/tools_favicon.ico">
    <script src="./js/jquery-3.4.1.min.js"></script>
    <style>
        .header-mobile {
            grid-template-rows: 1fr !important;
            grid-template-areas: "." !important;
            margin-bottom: 40px !important;
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

    <form method="post" action="./index.php?page=openPRC&source=prcColorCommon" enctype="multipart/form-data" id="openForm">
        <input name="fileInput" id='fileInput' type='file' accept=".prc" hidden />
    </form>

    <form method="post" action="./index.php?page=savePRC&outputName=common_color_table.prc" enctype="multipart/form-data" id="saveForm">
        <input name="json" id="jsonInput" hidden />
    </form>


    <div class="buttons">
        <div class="button-parent">
            <button class="tablinks" id="open">Open</button>
        </div>

        <div class="button-parent">
            <button class="tablinks" id="save">Save</button>
        </div>

        <div class="button-parent">
            <button class="tablinks" id="default" onclick="window.location.href = this.getAttribute('data-href')" data-href="./index.php?page=prcColorCommon&id=prcColorCommon">Load Default</button>
        </div>

        <div class="button-parent">
            <button class="tablinks" id="randomBtn" onclick="ShowModal('randomizeOptions')">Randomize!</button>
        </div>
    </div>

    <div style="text-align: center; font-weight: bold;">
        <span>The saved file <span style="color: orangered;">common_color_table.prc</span> goes in <span style="color: blue;">ui/param/common</span></span>
    </div>

    <br>

    <div id="main-section">
        <div class="buttons">
            <div class="button-parent">
                <button class="tablinks" onclick="openTab(event, 'com_color_table')">Common</button>
            </div>
            <div class="button-parent">
                <button class="tablinks" onclick="openTab(event, 'dmg_color_table')">Damage</button>
            </div>
            <div class="button-parent">
                <button class="tablinks" onclick="openTab(event, 'hp_color_table')">HP</button>
            </div>
        </div>
        <br>
        <div class="tab-content">
            <div class="tab-page options" id="com_color_table">
            </div>
            <div class="tab-page options" id="dmg_color_table">
            </div>
            <div class="tab-page options" id="hp_color_table">
            </div>
        </div>
    </div>

    <script src="./js/prcColorCommon.js"></script>
</body>

</html>