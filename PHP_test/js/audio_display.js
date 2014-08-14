/**
 * Created by tanis on 8/14/14.
 */

function get_audio(){
    var usr = 18;
    var profileid = document.getElementById("profile_select").value;
    console.log(profileid);
    var url = "sever_script/get_audio.php";
    var params = "user_id=" + usr+"&profileid="+profileid;
    var identifier = "result";


    localStorage.clear();
    var message;
    var status = processData(params, url, identifier);
    if (status != 200) {
        message = "Error getting web page: status = " + status;
        return message;
    }
    var result_data = localStorage.getItem("result");
    //console.log(result_data);
    var result_obj = JSON.parse(result_data);
    var audio_collection = result_obj.audio_collection;
    //console.log(result);
    message = result_obj.message;

    return {"audio_collection":audio_collection, "message":message};
}

function display_audio(){
    var return_obj=get_audio();
    //console.log(audios);
    var audio_info=return_obj.audio_collection;
    console.log(audio_info);
    var thumb_url;
    var content="";
    $.each(audio_info,function(i,audio){
        ado_url="."+audio.audio_url;
        //console.log(thumb_url);
        //console.log(audio.audio_url);

        content+="<div class=\"col-xs-4 audio-dis-col\">"+
                    "<div style='text-align: center;'>"+
                    "<audio controls>"+
                        "<source src='"+ ado_url+"' type='audio/mpeg'>"+
                        "Your browser does not support the audio element."+
                    "</audio>"+"</div>"+
                    "<input type='checkbox' value='"+audio.identity_profiler_id+"' style='position: absolute'>"+
                    "<label style='text-align: center;'>"+
                    audio.title+
                    "</label>"+
                    "</div>";
        //var container = $( "<div>" ).attr("class", "col-xs-3").appendTo("#audios");
        //var audio_link = $( "<a>").attr("class", "thumbnail").appendTo(container);
        //$( "<img>" ).attr("src", thumb_url).appendTo( audio_link );
        //console.log(i);
    });
    document.getElementById("audios").innerHTML=content;

    console.log("successed on ajax");
    //console.log(audio_info);
    //$("#test").html(data.responseText);
}

function show_error(){
    console.log("failed on ajax");
    $("#test").html("failed");
}

$(document).ready(function(){
    display_audio();
    $("#profile_select").change(display_audio);
});

// Alert messages
function my_wami_alert (message, message_type_class, message_type_string, message_type) {
    if (message_type === "header")  {
        if (message === '') {
            document.getElementById("header").innerHTML = message;
            return;
        }
    }
    if (message_type === "audio_upload")  {
        if (message === '') {
            document.getElementById("audio_upload_alerts").innerHTML = message;
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
    if (message_type === "audio_upload") document.getElementById("audio_upload_alerts").innerHTML = alert_str;
    if (message_type === "html_alerts") document.getElementById("html_alerts").innerHTML = alert_str;
}