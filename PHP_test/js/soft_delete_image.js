/**
 * Created by tanis on 8/9/14.
 */

$(document).ready(function(){

});

function image_select(){
    var images="";
    $(".image-dis-col input:checkbox:checked").each(function(){
        if (this.checked) {
            images+=$(this).val()+",";
        }
    });
    return images.substring(0, images.length-1);
}

function delete_request(){

    var url = "sever_script/soft_delete_image.php";
    var images = image_select();
    console.log(images);
    var params = "user_id=18"+"&images="+images;
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

function soft_delete_image(){
    var count=0;
    $(".image-dis-col input:checkbox:checked").each(function(){
        if (this.checked) {
            count ++;
        }
    });
    if(count===0){
        my_wami_alert("You have to select a image to delete", "alert-danger", "Error!  ", "html_alerts");
        return;
    }else{

        var result_obj = delete_request();

        display_image();
    }
}