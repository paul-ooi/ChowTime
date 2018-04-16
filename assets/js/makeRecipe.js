$(document).ready(function(){

    var count = ($(".steps").length) - 1;
    $("#moreRows").click(function(){
        //APPEND ANOTHER INPUT TYPE. FOR EACH NEW ROW
        count ++;
        var instruction = "<li><input type='text' class='form-control' name='item["+ count +"][step]' value='' /></li>";
        $(".list-of-instructions").append(instruction);
    })

    //GIVE THE APPROPRIATE SPICY LEVEL TO HIDDEN VALUE

    //STYLING FOR ADDING MORE ROWS TEXT
    $("#moreRows").hover(function(){
        $(this).css("color", "rgb(199, 74, 65)");
        $(this).css("cursor", "pointer");
    }, function(){
        $(this).css("color", "rgb(73, 73, 73)");
        $(this).css("cursor", "inherit");
    })

    //ON HOVER OF THE IMAGE, SHOW THE SPECIFIC BUTTON
    $(".currImgDel").hover(function(e) {
        e.currentTarget.nextElementSibling.style.display = "block";
        $(".deleteButton").css("cursor", "pointer");
        $(this).css("cursor", "pointer");
    }, function(e) {
        e.currentTarget.nextElementSibling.style.display = "none";
    });

    $(".deleteButton").hover(function() {
        $(this).css("display", "block");
    }, function() {
        $(this).css("display", "none");
    })

    //DELETING THE IMAGE FOR UPDATING THE RECIPE
    var imgSrc = $(".imgSrc");
    $(".imgSrc").click(function (e) {
        var img_tag = e.currentTarget.previousElementSibling;
        var img_src = img_tag.getAttribute("src");
        var data = { 'img_src': img_src };
        var ajaxUrl = '/chowtime/controllers/makeRecipe/updateRecipe.php';
        $.post(ajaxUrl, data, function (result) {
            window.location.reload();
            $("#delImgErr").html(result);
        })
    })


}) //END DOCUMENT READY

/*
value="<?php if(isset($_POST['step"+stepNum+"'])) {
    echo $_POST['step"+stepNum+"'];
}"
*/
