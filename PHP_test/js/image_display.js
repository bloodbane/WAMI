/**
 * Created by tanis on 7/10/14.
*/

function get_image(){
    var usr = 18;
    var url = "sever_script/get_image.php";
    var params = "user_id=" + usr;
    var identifier = "result";

    localStorage.clear();
    var message;
    var status = processData(params, url, identifier);
    if (status != 200) {
        message = "Error getting web page: status = " + status;
        return message;
    }
    var result_data = localStorage.getItem("result");
    console.log(result_data);
    var result_obj = JSON.parse(result_data);
    var result = result_obj.result;
    console.log(result);
    message = result_obj.message;

    return {"result":result, "message":message};
}

function display_image(){
    var return_obj=get_image();
    console.log(images);
    var image_info=return_obj.result;
    console.log(image_info);
    var thumb_url;
    $.each(image_info,function(i,image){
        thumb_url="."+image.thumb_url;
        console.log(thumb_url);
        var container = $( "<div>" ).attr("class", "col-xs-3").appendTo("#images");
        var image_link = $( "<a>").attr("class", "thumbnail").appendTo(container);
        $( "<img>" ).attr("src", thumb_url).appendTo( image_link );
        console.log(i);
    });
    console.log("successed on ajax");
    //console.log(image_info);
    //$("#test").html(data.responseText);
}

function show_error(){
    console.log("failed on ajax");
    $("#test").html("failed");
}

$(document).ready(function(){
    display_image();
});
