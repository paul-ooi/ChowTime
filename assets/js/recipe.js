$(document).ready(function(){
    // ON CLICK OF EACH THUMBNAIL, REPLACE THE MAIN IMAGE
    $(".thumbnail").click(function(){
        //GET THE CLICKED IMG SOURCE AND REPLACE MAIN IMG
        var imgSrc = $(this).attr("src");
        $("#main").attr("src", imgSrc);
    })

})//END PAGE LOAD


//ON CLICK, RUN THE GETAUTHCODE FUNCTON WHICH WILL REDIRECT THE USER TO SPECIFIED HEADER
var CREDENTIALS = {
    client_id: "4960227825098436719",
    appSecret: "36392d393adedbedd963b1aed504d396b0c7eecf23db11cd3e2d3aa9a93c1d3d"

}

function getAuthCode(credentials) {
    var REQUEST = {
        url: 'https://api.pinterest.com/oauth/',
        response_type: 'code',
        client_id: credentials['client_id'],
        state: 'thisisarandomstatethatirememberdoinginclass',
        scope: 'write_public, read_public',
        redirect_uri: 'http://localhost/chowtime/pages/recipes.php'
    }
}




//IF IMAGE COUNT OF THE THUMBNAILS IS GREATER THAN 3, THEN HIDE THEM?
