$(document).ready(function(){
    $("#moreRows").click(function(){
        //APPEND ANOTHER INPUT TYPE
        var stepNum = $(".steps").length;
        var instruction = "<li><input type='text' class='form-control' name='step"+ stepNum +"' value='' /></li>";

        $(".list-of-instructions").append(instruction);
    })

})

/*
value="<?php if(isset($_POST['step"+stepNum+"'])) {
    echo $_POST['step"+stepNum+"'];
}"
*/
