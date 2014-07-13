/**
 * Created by tanis on 7/10/14.
 */



$(document).ready(function(){
    var usr = 18;
    $.ajax({
        url: "./sever_script/getImage.php?usr_Id="+usr,
        type: "POST",
        //data: { id : usr_Id },
        dataType: "html",
        complete: display,
        error:show_error
    });
})



function display(data){
    console.log("successed on ajax");
    console.log(data);
    $("#test").html(data.responseText);
}

function show_error(){
    console.log("failed on ajax");
    $("#test").html("failed");
}