/**
 * Created by tanis on 8/14/14.
 */



$(document).ready(function(){

});

function audio_select(){
    var audios="";
    $(".audio-dis-col input:checkbox:checked").each(function(){
        if (this.checked) {
            audios+=$(this).val()+",";
        }
    });
    return audios.substring(0, audios.length-1);
}

function delete_request(){

    var url = "sever_script/soft_delete_audio.php";
    var audios = audio_select();
    console.log(audios);
    var params = "user_id=18"+"&audios="+audios;
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

function soft_delete_audio(){
    var count=0;
    $(".audio-dis-col input:checkbox:checked").each(function(){
        if (this.checked) {
            count ++;
        }
    });
    if(count===0){
        my_wami_alert("You need to select a audio to delete", "alert-danger", "Error!  ", "html_alerts");
        return;
    }else{

        var result_obj = delete_request();

        display_audio();
    }
}