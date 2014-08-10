/**
 * Created by tanis on 7/17/14.
 */

function previewImage() {
    my_wami_alert("", "", "", "file_type_alerts");

    //get file and check type
    var file = document.getElementById('new_image').files[0];

    document.getElementById("title").value="";
    document.getElementById("description").value="";
    var imageType = /image.*/;
    if (!file.type.match(imageType)) {
        my_wami_alert("File must be either a .jpg or .png image type.", "alert-danger", "Error!  ", "html_alerts");
        return;
    }
    //display file
    var preview = document.createElement("IMG");
    var reader  = new FileReader();
    var image_id = document.getElementById("image");
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
    reader.onloadend =
        function () {
            image_id.innerHTML = "";
            preview.setAttribute("src", reader.result);
            preview.setAttribute("class", "preview");
            image_id.appendChild(preview);
            $("#image_modal").modal('show');
        }
}

function uploadImage(){
    my_wami_alert("", "", "", "image_upload");
    //get file and check type
    var file = document.getElementById('new_image').files[0];
    var byte_reader = new FileReader();
    if (file) {
        byte_reader.readAsDataURL(file);
    }
    //localStorage.clear();
    var identifier = "result";

    //save to file system and database
    byte_reader.onloadend =
        function () {
            var image_src = byte_reader.result;
            console.log(image_src);
            var identity_profile_id = localStorage.getItem("identity_profile_id");
            identity_profile_id = document.getElementById("profile_select").value;
            console.log(identity_profile_id);
            var title = document.getElementById("title").value;
            var description = document.getElementById("description").value;
            var filename = file.name;
            var username = localStorage.getItem("username");
            username = "Tanis";

            var params = "title=" + title + "&profileid=" + identity_profile_id +
                "&description=" +description+"&filename="+filename+"&username="+username+"&image_src=" + image_src ;
            var url = "sever_script/upload_image.php";
            var status = processData(params, url, identifier);
            if (status != 200) {
                my_wami_alert("Error getting web page: status = " + status, "alert-danger", "Error!  ", "image_upload");
                return;
            }
            var result_data = localStorage.getItem(identifier);
            var result_obj = JSON.parse(result_data);

            var ret_code = result_obj.ret_code;
            if (ret_code === -1) {
                my_wami_alert(result_obj.message, "alert-danger", "Error!  ", "image_upload");
                return;
            } else{
                $("#image_modal").modal('hide');
                display_image();
            }

        }

}

// Alert messages
function my_wami_alert (message, message_type_class, message_type_string, message_type) {
    if (message_type === "header")  {
        if (message === '') {
            document.getElementById("header").innerHTML = message;
            return;
        }
    }
    if (message_type === "image_upload")  {
        if (message === '') {
            document.getElementById("image_upload_alerts").innerHTML = message;
            return;
        }
    }
    if (message_type === "file_type_alerts")  {
        if (message === '') {
            document.getElementById("html_alerts").innerHTML = message;
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
    if (message_type === "html_alerts") document.getElementById("html_alerts").innerHTML = alert_str;
}