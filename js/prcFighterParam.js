const gravity = 1.818181818181818;

const api_url = "./api.php?function=loadPRC&id=";

var fighter_data = [];

var chara_select = [];

var walk_checkbox = false;
var dash_checkbox = false;
var run_checkbox = false;
var jump_speed_checkbox = false;
var jump_y_checkbox = false;
var jump_count_checkbox = false;
var weight_checkbox = false;
var scale_checkbox = false;

var maxDecimal = 2;


const form_data = [
    [
        ["walk_random_section", "walk_checkbox", "Walk Randomizer"],
        ["walkMinInput", "Walk Minimum"],
        ["walkMaxInput", "Walk Maximum"],
    ],
    [
        ["dash_random_section", "dash_checkbox", "Dash Randomizer"],
        ["dashMinInput", "Dash Minimum"],
        ["dashMaxInput", "Dash Maximum"],
    ],
    [
        ["run_random_section", "run_checkbox", "Run Randomizer"],
        ["runMinInput", "Run Minimum"],
        ["runMaxInput", "Run Maximum"],
    ],
    [
        ["jump_speed_random_section", "jumpSpeed_checkbox", "Jump Speed Randomizer"],
        ["jumpSpeedMinInput", "Jump Speed X Minimum"],
        ["jumpSpeedMaxInput", "Jump Speed X Maximum"],
    ],
    [
        ["jump_y_random_section", "jump_checkbox", "Jump Y Randomizer"],
        ["jumpMinInput", "Jump Y Minimum"],
        ["jumpMaxInput", "Jump Y Maximum"],
    ],
    [
        ["jump_count_random_section", "jump_count_checkbox", "Jump Count Randomizer"],
        ["jumpCountMinInput", "Jump Count Minimum"],
        ["jumpCountMaxInput", "Jump Count Maximum"],
    ],
    [
        ["weight_random_section", "weight_checkbox", "Weight Randomizer"],
        ["weightMinInput", "Weight Minimum"],
        ["weightMaxInput", "Weight Maximum"],
    ],
    [
        ["scale_random_section", "scale_checkbox", "Scale Randomizer"],
        ["scaleMinInput", "Scale Minimum"],
        ["scaleMaxInput", "Scale Maximum"],
    ]
];

window.onload = function () {

    this.setup();

    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let result = urlParams.get("id");
    if (result != undefined || result != null) {
        $(".loading").fadeIn();
        $.ajax({
            url: api_url + result,
            dataType: 'json',
            success: function (data) {
                fighter_data = data;

                fighter_data.struct.list.struct.forEach(function (item, index) {
                    var array = [item.hash40[0]["#text"], TranslateName(item.hash40[0]["#text"].replace("fighter_kind_", "")), index];

                    chara_select.push(array);
                });

                setupForm();
                UpdateInputs(document.getElementById("characters"));

                $(".loading").fadeOut('slow', function() {
                    $(".main-section").fadeIn();
                });

            },
            error: function (data) {
                alert("Failed getting json! (Please contact me on discord if this wasn't intentional @ Coolsonickirby#4030.)");
            }
        });


        document.getElementById("start_random").addEventListener("click", function () {
            randomizeValues();
            HideModal("randomizeOptions");
        });

        document.getElementById("start_shuffle").addEventListener("click", function(){
            shuffleValues();
            HideModal("shuffler");
        });
    }else{
        $(".message").show();
    }
}


function setup() {

    document.getElementById('open').addEventListener('click', openDialog);

    document.getElementById('save').addEventListener('click', save);

    function save() {

        if (fighter_data.length <= 0) {
            alert("No prc file is loaded!");
        } else {
            document.getElementById("jsonInput").value = JSON.stringify(fighter_data);

            document.getElementById("saveForm").submit();
        }

    }



    function openDialog() {
        document.getElementById('fileInput').click();
    }

    document.getElementById('fileInput').addEventListener('change', submitForm);

    function submitForm() {
        if (window.File && window.FileReader && window.FileList && window.Blob) {
            var file = document.getElementById("fileInput").files[0];
            var start = parseInt("0x00") || 0;
            var stop = parseInt("0x07");

            var reader = new FileReader();

            // If we use onloadend, we need to check the readyState.
            reader.onloadend = function (evt) {
                if (evt.target.readyState == FileReader.DONE) { // DONE == 2
                    if (evt.target.result == "paracobn") {
                        document.getElementById("openForm").submit();
                    } else {
                        alert("Invalid file has been submitted!");
                    }

                }
            };

            var blob = file.slice(start, stop + 1);
            reader.readAsBinaryString(blob);
        } else {
            var file = document.getElementById("fileInput").files[0];

            var file_ext = file.name.split('.').pop();

            if (file_ext == "prc") {
                document.getElementById("openForm").submit();
            } else {
                alert("Invalid file has been submitted!");
            }
        }

    }
}


function setupForm() {
    form_data.forEach(function (item, index) {

        var tmp_check;

        var tmp_group;

        item.forEach(function (innerItem, index) {
            if (index == 0) {
                var template = `
                <div class="form-group-check">
                        <label>${innerItem[2]}</label>
                        <input class="form-check-input random_select" type="checkbox" id="${innerItem[1]}" value="${innerItem[0]}">
                </div>
                <div id="${innerItem[0]}" class="random_input_section">
                </div>
                `;
                document.getElementById("form-append").innerHTML = document.getElementById("form-append").innerHTML + template;

                tmp_check = document.getElementById(innerItem[1]);

                tmp_group = document.getElementById(innerItem[0]);

                tmp = innerItem[1];
            } else {
                var template = generateRandomFormInput(innerItem[0], innerItem[1]);
                tmp_group.innerHTML = tmp_group.innerHTML + template;
            }

        });

        setupHideListener(tmp_check);

        document.getElementById("form-append").innerHTML = document.getElementById("form-append").innerHTML + "<hr>";

    });

    var chara_base = `
    <div class="form-group-check">
        <label>Enable Character Selection</label>
        <input class="form-check-input chara_select" type="checkbox" id="chara_select_enable">
    </div>
    <div class="form-group-multiple-chara" id="chara_select_options" style="display: none;">
        <label>Select the characters you want randomized (Leave all blank for everyone)</label>
        <div id="chara-append">
        </div>
    </div>`;

    document.getElementById("form-append").innerHTML = document.getElementById("form-append").innerHTML + chara_base;

    chara_select.forEach(function (item, index) {
        var template = `
            <div class="form-chara-check">
                <input type="checkbox" id="${item[0]}">
                <label for="${item[0]}">
                    ${item[1]}
                </label>
            </div>
        `;

        var node = document.createElement("option");
        node.value = index;
        node.innerHTML = item[1];

        document.getElementById("characters").append(node);


        document.getElementById("chara-append").innerHTML = document.getElementById("chara-append").innerHTML + template
    });

    $(`#chara_select_enable`).click(function (e) {
        $(`#chara_select_options`).toggle();
    });
}

function UpdateInputs(e) {

    var floats = document.querySelectorAll(`input[id^="float"]`);

    var ints = document.querySelectorAll(`input[id^="int"]`);

    var bools = document.querySelectorAll(`input[id^="bool"]`);

    floats.forEach(function (item, index) {
        item.value = fighter_data.struct.list.struct[e.value].float[item.id.replace("float", "")]["#text"];

        item.addEventListener("input", function () {
            if (item.value == "") {
                return;
            } else {
                fighter_data.struct.list.struct[e.value].float[item.id.replace("float", "")]["#text"] = item.value;
            };
        });
    });

    ints.forEach(function (item, index) {
        item.value = fighter_data.struct.list.struct[e.value].int[item.id.replace("int", "")]["#text"];

        item.addEventListener("input", function () {
            if (item.value == "") {
                return;
            } else {
                fighter_data.struct.list.struct[e.value].int[item.id.replace("int", "")]["#text"] = item.value;
            };
        });
    });

    bools.forEach(function (item, index) {
        if (fighter_data.struct.list.struct[e.value].bool[item.id.replace("bool", "")]["#text"] == "True") {
            item.checked = true;
        } else {
            item.checked = false;
        };

        item.addEventListener("change", function (element) {
            if (element.target.checked) {
                fighter_data.struct.list.struct[e.value].bool[item.id.replace("bool", "")]["#text"] = "True";
            } else {
                fighter_data.struct.list.struct[e.value].bool[item.id.replace("bool", "")]["#text"] = "False";
            }
        });
    });

};

function setupHideListener(checkbox) {
    $(document).on('click', `#${checkbox.id}`, function (e) {
        $(`#${e.target.value}`).toggle();
    });
}


function generateRandomFormInput(id, text) {
    return `<div class="form-group-inline">
                <label for="${id}" class="col-sm-6 col-form-label">${text}</label>
                <input name=${id} id="${id}" class="form-control input-value">
            </div>`;
};


function getRandomFloat(min, max, fixed) {
    fixed = fixed || 0;

    var answer = 0;

    if (min == max) {
        answer = min;
    } else {
        if (fixed == 0) {
            answer = (Math.random() * (max - min) + min);
        } else {
            answer = (Math.random() * (max - min) + min).toFixed(fixed);
        }
    };

    return answer;

}

//Shoutouts to mozilla
function getRandomInt(min, max) {
    if (min == max) {
        return min;
    } else {
        min = Math.ceil(min);
        max = Math.floor(max);
        return Math.floor(Math.random() * (max - min)) + min; //The maximum is exclusive and the minimum is inclusive
    };
}

function changeJumpY(e) {

    if (document.getElementById("auto_calculate_jump_y").checked) {
        if (e.id == "float15") {
            document.getElementById("float16").value = (e.value * gravity).toFixed(maxDecimal);
        } else if (e.id == "float16") {
            document.getElementById("float15").value = (e.value / gravity).toFixed(maxDecimal);
        };
    };

    return;
}

let blacklist = {
    "bool": [
        1,
        3,
        4,
    ]
}

function shuffleValues() {
    let val = $('input[name="shuffle_type"]:checked').val();
    let original_fighters = [];
    switch(val){
        case "all":
            let cache = [];
            for(let i = 0; i < fighter_data.struct.list.struct.length; i++){
                // original_fighters.push(JSON.parse(JSON.stringify(fighter_data.struct.list.struct[i])));

                let rand = getRandomInt(0, fighter_data.struct.list.struct.length);

                while(cache.includes(rand) || i == rand){
                    rand = getRandomInt(0, fighter_data.struct.list.struct.length);
                }

                cache.push(rand);
                console.log(`Shuffling ${fighter_data.struct.list.struct[i].hash40[0]["#text"]} with ${fighter_data.struct.list.struct[rand].hash40[0]["#text"]}`);


                fighter_data.struct.list.struct[i].bool = fighter_data.struct.list.struct[rand].bool;
                fighter_data.struct.list.struct[i].float = fighter_data.struct.list.struct[rand].float;
                fighter_data.struct.list.struct[i].int = fighter_data.struct.list.struct[rand].int;
            }
            break;
    }

    // for(let i = 0; i < fighter_data.struct.list.struct.length; i++){
    //     blacklist["bool"].forEach((black_index) => {
    //         fighter_data.struct.list.struct[i].bool[black_index]["#text"] = original_fighters[i].bool[black_index]["#text"];
    //     });
    // }


    UpdateInputs(document.getElementById("characters"));
}


function randomizeValues() {

    var random_options = $('.random_select:checkbox');

    var character_select = $('.chara_select:checkbox');

    var selected_characters = {};

    //#region Random Variables
    var walkMin = 1;

    var walkMax = 5;

    var dashMin = 1.5;

    var dashMax = 3;

    var runMin = 1;

    var runMax = 5;

    var jumpSpeedMin = 0.1;

    var jumpSpeedMax = 1.2;

    var jumpMax = 50;

    var jumpMin = 10;

    var jumpCountMin = 2;

    var jumpCountMax = 10;

    var weightMin = 1.2;

    var weightMax = 3.5;

    var scaleMin = 0.2;

    var scaleMax = 2.4;

    //#endregion

    //#region Booleans for checking
    var one_selection = false;
    var one_character_selected = false;
    //#endregion

    $(random_options).each(function (i) {
        if (this.checked) {
            window[this.id] = true;

            one_selection = true;

            switch (this.id) {
                case "walk_checkbox":
                    walkMin = parseFloat(document.getElementById("walkMinInput").value) || walkMin;
                    walkMax = parseFloat(document.getElementById("walkMaxInput").value) || walkMax;
                    walk_checkbox = true;
                    break;
                case "dash_checkbox":
                    dashMin = parseFloat(document.getElementById("dashMinInput").value) || dashMin;
                    dashMax = parseFloat(document.getElementById("dashMaxInput").value) || dashMax;
                    dash_checkbox = true;
                    break;
                case "run_checkbox":
                    runMin = parseFloat(document.getElementById("runMinInput").value) || runMin;
                    runMax = parseFloat(document.getElementById("runMaxInput").value) || runMax;
                    run_checkbox = true;
                    break;
                case "jumpSpeed_checkbox":
                    jumpSpeedMin = parseFloat(document.getElementById("jumpSpeedMinInput").value) || jumpSpeedMin;
                    jumpSpeedMax = parseFloat(document.getElementById("jumpSpeedMaxInput").value) || jumpSpeedMax;
                    jump_speed_checkbox = true;
                    break;
                case "jump_checkbox":
                    jumpMin = parseFloat(document.getElementById("jumpMinInput").value) || jumpMin;
                    jumpMax = parseFloat(document.getElementById("jumpMaxInput").value) || jumpMax;
                    jump_y_checkbox = true;
                    break;
                case "jump_count_checkbox":
                    jumpCountMin = parseFloat(document.getElementById("jumpCountMinInput").value) || jumpCountMin;
                    jumpCountMax = parseFloat(document.getElementById("jumpCountMaxInput").value) || jumpCountMax;
                    jump_count_checkbox = true;
                    break;
                case "weight_checkbox":
                    weightMin = parseFloat(document.getElementById("weightMinInput").value) || weightMin;
                    weightMax = parseFloat(document.getElementById("weightMaxInput").value) || weightMax;
                    weight_checkbox = true;
                    break;
                case "scale_checkbox":
                    scaleMin = parseFloat(document.getElementById("scaleMinInput").value) || scaleMin;
                    scaleMax = parseFloat(document.getElementById("scaleMaxInput").value) || scaleMax;
                    scale_checkbox = true;
                    break;
                default:
                    console.log("but nothing happened...")
                    break;
            }

        } else {
            window[this.id] = false;
        };
    });

    $(character_select).each(function (i) {
        if (this.checked) {
            selected_characters[this.id] = true;
            one_character_selected = true;
        };
    });

    if (one_selection == false) {
        return alert("You need at least one enabled!");
    };


    fighter_data.struct.list.struct.forEach(element => {
        var walk_replace = {
            2: getRandomFloat(walkMin, walkMax, maxDecimal), // Walk Speed Max
            4: getRandomFloat(walkMin, walkMax, maxDecimal), // Walk Middle Ratio
            5: getRandomFloat(walkMin, walkMax, maxDecimal), // Walk Fast Ratio
        };

        var dash_replace = {
            7: getRandomFloat(dashMin, dashMax, maxDecimal), // Dash Speed
        };

        var run_replace = {
            8: getRandomFloat(runMin, runMax, maxDecimal), //Run Accel Mul(tiplier?)
            9: getRandomFloat(runMin, runMax, maxDecimal), // Run Accel Add
            10: getRandomFloat(runMin, runMax, maxDecimal), // Run Speed Max
        };

        var jump_speed_replace = {
            11: getRandomFloat(jumpSpeedMin, jumpSpeedMax, maxDecimal), // Junp Speed X
            12: getRandomFloat(jumpSpeedMin, jumpSpeedMax, maxDecimal), // Jump Speed X Mul(tiplier?)
            13: getRandomFloat(jumpSpeedMin, jumpSpeedMax, maxDecimal), // Jump Speed X Max
            14: getRandomFloat(jumpSpeedMin, jumpSpeedMax, maxDecimal), // Jump Aerial Speed X Mul(tiplier?)
        };


        var jump_y_replace = {
            16: getRandomFloat(jumpMin, jumpMax), // jump_y
            15: "special case", // jump_inital_y
            18: getRandomFloat(jumpMin, jumpMax, maxDecimal), // jump_areial_y
            17: getRandomFloat(jumpMin, jumpMax, maxDecimal), // mini_jump_y
        };

        var weight_replace = {
            29: getRandomFloat(weightMin, weightMax, maxDecimal), // Weight
        };

        var scale_replace = {
            38: getRandomFloat(scaleMin, scaleMax, maxDecimal), // Scale
        };

        var floatReplace = {};

        if (walk_checkbox) {
            for (const property in walk_replace) {
                floatReplace[property] = walk_replace[property];
            }
        };

        if (dash_checkbox) {
            for (const property in dash_replace) {
                floatReplace[property] = dash_replace[property];
            }
        };

        if (run_checkbox) {
            for (const property in run_replace) {
                floatReplace[property] = run_replace[property];
            }
        };

        if (jump_speed_checkbox) {
            for (const property in jump_speed_replace) {
                floatReplace[property] = jump_speed_replace[property];
            }
        };

        if (jump_y_checkbox) {
            for (const property in jump_y_replace) {
                if (property == 15) {
                    floatReplace[property] = (jump_y_replace[16] / gravity).toFixed(maxDecimal);
                } else {
                    floatReplace[property] = jump_y_replace[property];
                }
            }
        };

        if (weight_checkbox) {
            for (const property in weight_replace) {
                floatReplace[property] = weight_replace[property];
            }
        };

        if (scale_checkbox) {
            for (const property in scale_replace) {
                floatReplace[property] = scale_replace[property];
            }
        };


        if (one_character_selected) {

            if (selected_characters[element.hash40[0]["#text"]]) {

                if (jump_count_checkbox) {
                    element.int[14]["#text"] = getRandomInt(jumpCountMin, jumpCountMax);
                };

                for (const property in floatReplace) {
                    element.float[property]["#text"] = floatReplace[property];
                };
            };

        } else {
            if (jump_count_checkbox) {
                element.int[14]["#text"] = getRandomInt(jumpCountMin, jumpCountMax);
            };

            for (const property in floatReplace) {
                element.float[property]["#text"] = floatReplace[property];
            };
        };

    });

    UpdateInputs(document.getElementById("characters"));

    alert("Randomization Complete!");
    return;
}


function ShowModal(id){
    $(`#${id}`).fadeIn(100);
    document.getElementById(id).style.overflow = "auto";
    document.body.style.overflow = "hidden";
}

function HideModal(id){
    $(`#${id}`).fadeOut(100);
    document.body.style.overflow = "auto";
}

function openTab(evt, type, display_type) {
    display_type = (typeof display_type !== 'undefined') ? display_type : "grid"

    // Declare all variables
    var i, tabcontent, tablinks;

    tabcontent = document.getElementsByClassName("tab-page");
    for (i = 0; i < tabcontent.length; i++) {
        tabcontent[i].style.display = "none";
    }

    // Get all elements with class="tablinks" and remove the class "active"
    tablinks = document.getElementsByClassName("tablinks");
    for (i = 0; i < tablinks.length; i++) {
        tablinks[i].className = tablinks[i].className.replace(" active", "");
    }

    // Show the current tab, and add an "active" class to the button that opened the tab
    document.getElementById(type).style.display = display_type;
    evt.currentTarget.className += " active";
}
