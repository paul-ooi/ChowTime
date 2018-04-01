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

})

/*
value="<?php if(isset($_POST['step"+stepNum+"'])) {
    echo $_POST['step"+stepNum+"'];
}"
*/
