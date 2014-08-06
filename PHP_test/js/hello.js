/**
 * Created by tanis on 7/5/14.
 */
$(document).ready(function(){
    $("#try").click(function(){
        var chosen = $("input:radio[name='sc']:checked").val();
        console.log(chosen);
        if(chosen==="plain"){
            alert("Hello,World!");
        }else if(chosen==="bootstrap"){
            $('#myModal').modal('show');
        }else{
            alert("Please choose one!")
        }
        //console.log("worked");
        //
        jwplayer("Lucy_1").setup({
            file: "./videos/Lucy TRAILER 1 (2014) - Luc Besson, Scarlett Johansson Movie HD.mp4"//,
            //image: "/videos/myPoster.jpg"
        });
    });

    jwplayer("Lucy_2").setup({
        file: "./videos/Lucy Trailer 2.mp4"//,
        //image: "/videos/myPoster.jpg"
    });
});