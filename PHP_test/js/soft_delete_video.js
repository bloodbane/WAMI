/**
 * Created by tanis on 8/13/14.
 */


$(document).ready(function(){

});

function video_select(){
    var videos="";
    $(".video-dis-col input:checkbox:checked").each(function(){
        if (this.checked) {
            videos+=$(this).val()+",";
        }
    });
    return videos.substring(0, videos.length-1);
}

function delete_request(){

    var url = "sever_script/soft_delete_video.php";
    var videos = video_select();
    console.log(videos);
    var params = "user_id=18"+"&videos="+videos;
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
    var ret_code = result_obj.ret_code;
    //console.log(result);
    message = result_obj.message;

    return {"ret_code":ret_code, "message":message};
}

function soft_delete_video(){
    var count=0;
    $(".video-dis-col input:checkbox:checked").each(function(){
        if (this.checked) {
            count ++;
        }
    });
    if(count===0){
        my_wami_alert("You need to select a video to delete", "alert-danger", "Error!  ", "html_alerts");
        return;
    }else{

        var result_obj = delete_request();

        display_video();
    }
}