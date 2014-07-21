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
    var result_obj = JSON.parse(result_data);
    var result = result_obj.result;
    message = result_obj.message;

    return [result, message];
}

function display_image(){
    var images=get_image();
    var image_info=images.result;
    $.each(image_info,function(i,image){
        $( "<img>" ).attr( "src", image.thumb_url).appendTo( "#test" );
    });
    console.log("successed on ajax");
    console.log(image_url);
    //$("#test").html(data.responseText);
}

function show_error(){
    console.log("failed on ajax");
    $("#test").html("failed");
}

display_image();
