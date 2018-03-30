<?php
if(isset($_POST['updRecipe'])) {
    var_dump($_POST);
}

 ?>


<form method="post" action="_addRecipe.php">
    <div class="field">
        <input type="hidden" id="u_id" name="u_id" value="" />
    </div>

    <div class="field">
        <input type="file" id="img_url" name="img_url" />
    </div>

    <div class="field">
        title:<input type="text" id="title" name="title" value="" />
    </div>

    <div class="field">
        descr:<input type="text" id="descr" name="descr" value="" />
    </div>

    <div class="field">
        total time:<input type="time" id="t_time" name="t_time" value="" />
    </div>

    <div class="field">
        prep time:<input type="time" id="p_time" name="p_time" value="" />
    </div>

    <div class="field">
        cook time:<input type="time" id="c_time" name="c_time" value="" />
    </div>

    <div class="field">
        dish level:<input type="number" id="d_lvl" name="d_lvl" value="" />
    </div>

    <div class="field">
        ingred level:<input type="number" id="ingred" name="ingred" value="" />
    </div>

    <div class="field">
        community diff level:<input type="number" id="diff" name="diff" value="" />
    </div>

    <div class="field">
        spicy level:<input type="number" id="spice_lvl" name="spice_lvl" value="" />
    </div>

    <div class="field">
        recommended diff:<input type="number" id="recommD" name="recommD" value="" />
    </div>

    <div class="field">
        posted date:<input type="time" id="p_date" name="p_date" value="" />
    </div>

    <div class="field">
        steps:<input type="text" id="steps" name="steps" value="" />
    </div>

    <input type="submit" id="updRecipe" name="updRecipe" value="Update" />
</form>

<!--
http://php.net/manual/en/function.copy.php
http://php.net/manual/en/function.move-uploaded-file.php
 -->
