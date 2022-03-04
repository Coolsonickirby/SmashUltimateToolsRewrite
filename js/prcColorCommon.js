var color_data;

window.onload = function() {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    let result = urlParams.get("id");
    if (result != undefined || result != null) {
        $.ajax({
            url: "./api.php?function=loadPRC&id=" + result,
            dataType: 'json',
            success: function(data) {
                color_data = data;
                setupForm();
            },
            error: function(data) {
                alert("Failed getting json! (Please contact me on discord if this wasn't intentional @ Coolsonickirby#4030.)");
            }
        });
    }

    document.getElementById('open').addEventListener('click', openDialog);
    document.getElementById('fileInput').addEventListener('change', submitForm);
    document.getElementById('save').addEventListener('click', savePrc);
};

function openDialog() {
    document.getElementById('fileInput').click();
}


function savePrc() {
    document.getElementById("jsonInput").value = JSON.stringify(color_data);
    document.getElementById("saveForm").submit();
}

function submitForm() {
    if (window.File && window.FileReader && window.FileList && window.Blob) {
        var file = document.getElementById("fileInput").files[0];
        var start = parseInt("0x00") || 0;
        var stop = parseInt("0x07");

        var reader = new FileReader();

        // If we use onloadend, we need to check the readyState.
        reader.onloadend = function(evt) {
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


function RGBtoHEX(r, g, b) {
    return `${(r).toString(16).padStart(2, '0')}${(g).toString(16).padStart(2, '0')}${(b).toString(16).padStart(2, '0')}`;
}

function HEXtoRGB(hex) {
    if (hex.charAt(0) == '#') {
        hex = hex.slice(1);
    }

    let r = hex[0] + hex[1];
    let g = hex[2] + hex[3];
    let b = hex[4] + hex[5];

    return {
        "r": parseInt(r, 16),
        "g": parseInt(g, 16),
        "b": parseInt(b, 16),
    }
}

function setupForm() {
    for (var i = 0; i < color_data.struct.list.length; i++) {
        for (var j = 0; j < color_data.struct.list[i].struct.length; j++) {
            let main = color_data.struct.list[i].struct[j];

            let id = main["hash40"]["#text"];

            let split = main["hash40"]["#text"].split("_");

            let lbl_name = `${split[0].charAt(0).toUpperCase()}${split[0].slice(1)} ${split[1].toUpperCase()}`;

            let input_form = document.createElement("div");
            input_form.classList.add("input-form");

            input_form.innerHTML += `
                <label for="${id}">${lbl_name}</label>
                <br>
                <br>
            `;


            let byte_array = main.byte;
            let r = parseInt(byte_array[0]["#text"]);
            let g = parseInt(byte_array[1]["#text"]);
            let b = parseInt(byte_array[2]["#text"]);

            let color_input = document.createElement("input");
            color_input.type = "color";
            color_input.id = id;
            color_input.setAttribute("value", `#${RGBtoHEX(r, g, b)}`);

            color_input.addEventListener("input", (e) => {
                let rgb = HEXtoRGB(e.target.value);
                main.byte[0]["#text"] = rgb["r"];
                main.byte[1]["#text"] = rgb["g"];
                main.byte[2]["#text"] = rgb["b"];
            });

            input_form.appendChild(color_input);

            if (main["ushort"] != undefined) {
                id = `${id}_ushort`;

                let div_value = document.createElement("div");
                div_value.classList.add("input-form")
                div_value.innerHTML = `<br><br><label for="${id}">Value: </label>`;

                let value_threshold = document.createElement("input");
                value_threshold.id = id;
                value_threshold.type = "text";
                value_threshold.value = `${main["ushort"]["#text"]}`;

                value_threshold.addEventListener("input", (e) => {
                    main["ushort"]["#text"] = e.target.value;
                });

                div_value.appendChild(value_threshold);


                input_form.appendChild(div_value);
            }

            document.getElementById(color_data.struct.list[i]["@hash"]).appendChild(input_form);
        }
    }
    document.getElementById("main-section").style.display = "block";
}



function openTab(evt, type, display_type) {
    display_type = (typeof display_type !== 'undefined') ? display_type : "grid";

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