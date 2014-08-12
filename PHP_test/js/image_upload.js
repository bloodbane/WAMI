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
            //console.log(image_src);
            var identity_profile_id = localStorage.getItem("identity_profile_id");
            identity_profile_id = document.getElementById("profile_select").value;
            //console.log(identity_profile_id);
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
                //my_wami_alert(result_obj.message, "alert-danger", "Error!  ", "image_upload");
                $("#image_modal").modal('hide');
                localStorage.setItem('upload_params', params);
                console.log(filename);
                console.log(strrpos('filename', '.'));
                var content = filename.substring(0, strrpos(filename, '.'))+".png "+"is already exist. Do you want to replace it?";
                document.getElementById('replace_image').innerHTML=content;
                $("#message_modal").modal('show');
                return;
            } else{
                $("#image_modal").modal('hide');
                display_image();
            }

        }
}

function replace_image(){
    var params = localStorage.getItem('upload_params');
    params += "&replace=true";
    var url = "sever_script/upload_image.php";
    var identifier = "result";
    var status = processData(params, url, identifier);
    if (status != 200) {
        my_wami_alert("Error getting web page: status = " + status, "alert-danger", "Error!  ", "image_upload");
        return;
    }
    var result_data = localStorage.getItem(identifier);
    var result_obj = JSON.parse(result_data);

    var ret_code = result_obj.ret_code;
    if (ret_code === -1) {
        //my_wami_alert(result_obj.message, "alert-danger", "Error!  ", "image_upload");
        return;
        localStorage.clear();
    } else{
        $("#message_modal").modal('hide');
        display_image();
        localStorage.clear();
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

function strrpos(haystack, needle, offset) {
    //  discuss at: http://phpjs.org/functions/strrpos/
    // original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // bugfixed by: Onno Marsman
    // bugfixed by: Brett Zamir (http://brett-zamir.me)
    //    input by: saulius
    //   example 1: strrpos('Kevin van Zonneveld', 'e');
    //   returns 1: 16
    //   example 2: strrpos('somepage.com', '.', false);
    //   returns 2: 8
    //   example 3: strrpos('baa', 'a', 3);
    //   returns 3: false
    //   example 4: strrpos('baa', 'a', 2);
    //   returns 4: 2

    var i = -1;
    if (offset) {
        i = (haystack + '')
            .slice(offset)
            .lastIndexOf(needle); // strrpos' offset indicates starting point of range till end,
        // while lastIndexOf's optional 2nd argument indicates ending point of range from the beginning
        if (i !== -1) {
            i += offset;
        }
    } else {
        i = (haystack + '')
            .lastIndexOf(needle);
    }
    return i >= 0 ? i : false;
}