/**
 * Created by tanis on 7/10/14.
*/

function get_image(){
    var usr = 18;
    var profileid = document.getElementById("profile_select").value;
    var url = "sever_script/get_image.php";
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
    var image_collection = result_obj.image_collection;
    //console.log(result);
    message = result_obj.message;

    return {"image_collection":image_collection, "message":message};
}

function display_image(){
    var return_obj=get_image();
    //console.log(images);
    var image_info=return_obj.image_collection;
    //console.log(image_info);
    var thumb_url;
    var content="";
    $.each(image_info,function(i,image){
        thumb_url="."+image.thumb_url;
        console.log(thumb_url);
        console.log(image.image_url);

        content+="<div class=\"col-xs-3 image-dis-col\">"+
                    "<a class=\"thumbnail group3 cboxElement\" title=\""+ image.title +"\" href=\"."+ image.image_url +"\">"+
                        "<img src=\""+ thumb_url +"\"></img>"+
                    "</a>"+
                    "<label style='text-align: center'>"+
                    "<input type='checkbox' value='"+image.title+"'>"+
                    image.title+
                    "</label>"+
                "</div>";
        //var container = $( "<div>" ).attr("class", "col-xs-3").appendTo("#images");
        //var image_link = $( "<a>").attr("class", "thumbnail").appendTo(container);
        //$( "<img>" ).attr("src", thumb_url).appendTo( image_link );
        console.log(i);
    });
    document.getElementById("images").innerHTML=content;
    $(".group3").colorbox({rel:'group3', transition:"none", width:"60%", height:"75%"});
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
