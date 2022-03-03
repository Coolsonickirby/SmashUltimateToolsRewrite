<?php
$outputName = "";
if(isset($_GET["outputName"])){
    $outputName = $_GET["outputName"];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>MSBT Editor</title>
    <link rel="stylesheet" href="./css/new-front-page.css">
    <link rel="stylesheet" href="./css/msbt.css">
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

    <form method="post" action="./index.php?page=openMSBT&source=msbtEditor" enctype="multipart/form-data" id="openForm">
        <input name="fileInput" id='fileInput' type='file' accept=".msbt" hidden />
    </form>

    <form method="post" action="./index.php?page=saveMSBT&outputName=<?php echo $outputName; ?>" enctype="multipart/form-data" id="saveForm">
        <input name="json" id="jsonInput" hidden />
    </form>

    <div class="buttons">
        <div class="button-parent">
            <button id="open">Open</button>
        </div>
        <div class="button-parent">
            <button id="find">Find</button>
        </div>
        <div class="button-parent">
            <button id="save">Save</button>
        </div>
    </div>

    <div class="main">

        <div class="top">
            <select id="lstStrings" class="listbox_holder" size="0" onchange="changeTextArea(this)">
            </select>
        </div>

        <div class="mid">
            <textarea id="textarea"></textarea>

            <br>
            <br>
            <div class="find" id="searchSection">
                <div>
                    <label for="searchInput" style="font-size:1.5rem;">Search Input:</label>
                    <br>
                    <input name="searchInput" type="text" id="searchInput">
                    <br>
                    <div class="button-parent" style="margin-top: 1.5rem;">
                        <button id="searchBtn">Search</button>
                    </div>
                </div>

                <div>
                    <label for="searchResults" style="font-size:1.5rem;">Search Results:</label>
                    <br>
                    <select class="listbox_holder" id="searchResults" size="5" onchange="changeTextArea(this)">
                    </select>
                </div>
            </div>
        </div>

    </div>

    <script src="./js/jquery-3.4.1.min.js"></script>
    <script src="./js/msbt.js"></script>
</body>

</html>