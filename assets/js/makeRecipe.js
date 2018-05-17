$(document).ready(function(){

    // ADDING A NEW STEP //
    var count = ($(".steps").length) - 1;
    $("#moreRows").click(function(){
        //CLEAR ERROR MESSAGE
        $("#update_steps_error_mssg").html("");
        //APPEND ANOTHER INPUT TYPE. FOR EACH NEW ROW. Add CSS CURSOR TO EACH X
        count ++;
        var instruction = "<div class='row col-xs-12'><li class='col-xs-11 col-sm-11'><input type='text' class='form-control steps col-sm-12' name='item[" + count +"][step]' value='' /></li><button type='button' class='delete_step_button'><span class='delete_step col-xs-1 col-sm-1'>x</span></button></div>";
        $(".delete_step_button").css("cursor", "pointer");
        $(".list-of-instructions").append(instruction);
        document.addEventListener("click", onClickDeleteStep());
    })

    //STYLING FOR ADDING MORE ROWS TEXT
    $("#moreRows").hover(function(){
        $(this).css("color", "rgb(199, 74, 65)");
        $(this).css("cursor", "pointer");
    }, function(){
        $(this).css("color", "rgb(73, 73, 73)");
        $(this).css("cursor", "inherit");
    })

    //DELETING A ROW ON CLICK OF THE X
    onClickDeleteStep();
    function onClickDeleteStep() {
        //CLEAR ERROR MESSAGE
        $("#update_steps_error_mssg").html("");
        $(".delete_step_button").css("cursor", "pointer");
        $(".delete_step_button").click(function (e) {
            //CHECK THAT IT ISN'T THE LAST STEP
            if ((e.currentTarget.offsetParent.children["0"].children.length) > 1) {
                console.log("greater than 1");
                //GET THE ROW THAT WAS CLICKED AND REMOVE BOTH X AND ROW
                e.originalEvent.path[2].remove();
                this.remove();
            }
            else {
                $("#update_steps_error_mssg").html("You can't make a recipe without steps!");
                $("#update_steps_error_mssg").css("color", "red");
            }
        })   
    }

    // DELETING/EDITING IMAGES //
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
