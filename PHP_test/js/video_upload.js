/**
 * Created by tanis on 8/13/14.
 */

function previewVideo(){
    console.log("abc")
    my_wami_alert("", "", "", "file_type_alerts");

    //get file and check type
    var file = document.getElementById('new_video').files[0];

    document.getElementById("title").value="";
    document.getElementById("description").value="";

    document.getElementById("profileid").value="";
    document.getElementById("filename").value="";
    document.getElementById("username").value="";
    document.getElementById("file").value="";


    var videoType = /video.*/;
    if (!file.type.match(videoType)) {
        my_wami_alert("File must be either a .mp4 or .m4v video type.", "alert-danger", "Error!  ", "html_alerts");
        return;
    }


    //var identity_profile_id = localStorage.getItem("identity_profile_id");
    var identity_profile_id = document.getElementById("profile_select").value;
    //console.log(identity_profile_id);

    $("#profileid").val(identity_profile_id);
    $("#filename").val(file.name);
    $("#username").val(localStorage.getItem("username"));
    $("#username").val( "Tanis" );
    $("#file").files[0]=file;
    //display file
    /*
    var preview = document.createElement("IMG");
    var reader  = new FileReader();
    var video_id = document.getElementById("video");
    if (file) {
        reader.readAsDataURL(file);
    } else {
        preview.src = "";
    }
    reader.onloadend =
        function () {
            video_id.innerHTML = "";
            preview.setAttribute("src", reader.result);
            preview.setAttribute("class", "preview");
            video_id.appendChild(preview);
            $("#video_modal").modal('show');
        }
    */
    $("#video_modal").modal('show');

}


function uploadVideo(e) {
    e.preventDefault();
    $("#video_modal").modal('hide');
    $("#message_modal").modal('show');
    my_wami_alert("", "", "", "video_upload");
    var file = document.getElementById('new_video').files[0];
    $("#video_modal").modal('show');
    var content = "<div class='progress'>" +
        "<div class='bar'></div >" +
        "<div class='percent'>0%</div>" +
        "</div>" +
        "<div id='status'></div>";
    document.getElementById('message_modal').innerHTML = content;
    $(document).ready(function () {
        var bar = $('.bar');
        var percent = $('.percent');
        var status = $('#status');
        $('form').ajaxForm({
            beforeSend: function () {
                status.empty();
                var percentVal = '0%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            uploadProgress: function (event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            success: function () {
                var percentVal = '100%';
                bar.width(percentVal)
                percent.html(percentVal);
            },
            complete: function (xhr) {
                status.html(xhr.responseText);
            }
        });
    })
}
function replace_video(){
    var params = localStorage.getItem('upload_params');
    params += "&replace=true";
    var url = "sever_script/upload_video.php";
    var identifier = "result";
    var status = processData(params, url, identifier);
    if (status != 200) {
        my_wami_alert("Error getting web page: status = " + status, "alert-danger", "Error!  ", "video_upload");
        return;
    }
    var result_data = localStorage.getItem(identifier);
    var result_obj = JSON.parse(result_data);

    var ret_code = result_obj.ret_code;
    if (ret_code === -1) {
        //my_wami_alert(result_obj.message, "alert-danger", "Error!  ", "video_upload");
        return;
        localStorage.clear();
    } else{
        $("#replace_modal").modal('hide');
        display_video();
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
    if (message_type === "video_upload")  {
        if (message === '') {
            document.getElementById("video_upload_alerts").innerHTML = message;
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
    if (message_type === "video_upload") document.getElementById("video_upload_alerts").innerHTML = alert_str;
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