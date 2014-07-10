/**
 * Created by tanis on 7/10/14.
 */

function display(usr){
    var usr
    $.ajax({
        url: "./sever_script/getImage.php",
        type: "POST",
        data: { id : urs_Id },
        dataType: "json"
    });

}
