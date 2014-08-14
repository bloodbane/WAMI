/**
 * Created by tanis on 8/13/14.
 */


function get_video(){
    var usr = 18;
    var profileid = document.getElementById("profile_select").value;
    console.log(profileid);
    var url = "sever_script/get_video.php";
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
    var video_collection = result_obj.video_collection;
    //console.log(result);
    message = result_obj.message;

    return {"video_collection":video_collection, "message":message};
}

function display_video(){
    var return_obj=get_video();
    //console.log(videos);
    var video_info=return_obj.video_collection;
    //console.log(video_info);
    var thumb_url;
    var content="";
    $.each(video_info,function(i,video){
        thumb_url="."+video.thumb_url;
        //console.log(thumb_url);
        //console.log(video.video_url);

        content+="<div class=\"col-xs-6 video-dis-col\">"+
                    "<div id= vid_"+video.identity_profiler_id+"></div>"+
                    "<input type='checkbox' value='"+video.identity_profiler_id+"' style='position: absolute'>"+
            "<label style='text-align: center;'>"+
                        video.title+
                    "</label>"+
                "</div>";
        //var container = $( "<div>" ).attr("class", "col-xs-3").appendTo("#videos");
        //var video_link = $( "<a>").attr("class", "thumbnail").appendTo(container);
        //$( "<img>" ).attr("src", thumb_url).appendTo( video_link );
        //console.log(i);
    });
    document.getElementById("videos").innerHTML=content;
    $.each(video_info,function(i,video){
        var video_id = "vid_" + video.identity_profiler_id;
        console.log(video_id);
        jwplayer(video_id).setup({
            file: "."+video.video_url//,
            //image: "/videos/myPoster.jpg"
        });


    });
    console.log("successed on ajax");
    //console.log(video_info);
    //$("#test").html(data.responseText);
}

function show_error(){
    console.log("failed on ajax");
    $("#test").html("failed");
}

$(document).ready(function(){
    display_video();
    $("#profile_select").change(display_video);
});

