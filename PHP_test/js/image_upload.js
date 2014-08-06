/**
 * Created by tanis on 7/17/14.
 */

function uploadImage() {
    my_wami_alert("", "", "", "image_upload");

    //get file and check type
    var file = document.getElementById('new_image').files[0];
    var imageType = /image.*/;
    if (!file.type.match(imageType)) {
        my_wami_alert("File must be either a .jpg or .png image type.", "alert-danger", "Error!  ", "image_upload");
        return;
    }

    //display file
    var preview = new Image();
    var reader  = new FileReader();
    var byte_reader = new FileReader();
    var image_id = document.getElementById("image");
    if (file) {
        reader.readAsDataURL(file);
        byte_reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
    reader.onloadend =
        function () {
            image_id.innerHTML = "";
            preview.src = reader.result;
            image_id.appendChild(preview);
            $("#image_modal").modal('show');
        }

    //save to file system and database
    byte_reader.onloadend =
        function () {
            var image_src = byte_reader.result;
            var identity_profile_id = localStorage.getItem("identity_profile_id");
            //change file type to .png if its a jpg or gif. Keeps it compatible with android
            var file_name = file.name;
            var file_name_type_check = file_name.slice(file_name.lastIndexOf('.'));
            if (file_name_type_check !== '.png') {
                file_name = file_name.slice(0, file_name.indexOf('.')) + ".png";
            }
            var params = "file_name=" + file_name + "&image_src=" + image_src + "&identity_profile_id=" + identity_profile_id;
            var url = "save_new_profile_image_data.php";
            var status = processData(params, url, "result");
            if (status != 200) {
                my_wami_alert("Error getting web page: status = " + status, "alert-danger", "Error!  ", "image_upload");
                return;
            }
            var result_data = localStorage.getItem("result");
            var result_obj = JSON.parse(result_data);

            var ret_code = result_obj.ret_code;
            if (ret_code === -1) {
                my_wami_alert(result_obj.message, "alert-danger", "Error!  ", "image_upload");
                return;
            }
        }
}

// Alert messages
function my_wami_alert (message, message_type_class, message_type_string, message_type) {
    if (message_type === "header")  {
        if (message === '') {
            document.getElementById("header_alerts").innerHTML = message;
            return;
        }
    }
    if (message_type === "image_upload")  {
        if (message === '') {
            document.getElementById("image_upload_alerts").innerHTML = message;
            return;
        }
    }
    var alert_str = "<div class='alert " + message_type_class + " alert-dismissable'> " +
        "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button> " +
        "<strong>" + message_type_string + "</strong> " + message + "</div>";
    if (message_type === "header") document.getElementById("header_alerts").innerHTML = alert_str;
    if (message_type === "mywami") document.getElementById("mywami_alerts").innerHTML = alert_str;
    if (message_type === "new_profile") document.getElementById("new_profile_alerts").innerHTML = alert_str;
    if (message_type === "image_upload") document.getElementById("image_upload_alerts").innerHTML = alert_str;
}