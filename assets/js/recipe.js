$(document).ready(function(){
    // ON CLICK OF EACH THUMBNAIL, REPLACE THE MAIN IMAGE
    $(".thumbnail").click(function(){
        //GET THE CLICKED IMG SOURCE AND REPLACE MAIN IMG
        var imgSrc = $(this).attr("src");
        $("#main").attr("src", imgSrc);
    })

    //ON MOUSEOVER, REMOVE HIDDEN AND DISPLAY CAPTION
    // $(".icon").hover(function(e){
    //     $("div").removeClass("hidden");
    // }, function(e) {
    //     $(".caption").addClass("hidden");
    // })

})//END PAGE LOAD

//IF IMAGE COUNT OF THE THUMBNAILS IS GREATER THAN 3, THEN HIDE THEM?
