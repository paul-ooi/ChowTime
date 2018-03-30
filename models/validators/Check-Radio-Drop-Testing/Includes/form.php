<main>
    <form name="testForm" method="POST" action="index.php">
        <!-- CHECKBOXES -->
        <fieldset name="checkboxes">
            <legend>Checkboxes</legend>
            <?php foreach($drinks as $key => $value) : ?>
                <div class="option">
                    <label for="<?= $key ?>"><?= $value ?></label>
                    <input name="drink[]" type="checkbox" id="<?= $key ?>" value="<?= $key ?>"
                    <?php if(isset($inCheckBoxArr)) {
                            for($i=0; $i < count($inCheckBoxArr); $i++) {
                                if($inCheckBoxArr[$i] == $key) {
                                    echo "checked";
                                }
                            }
                        }
                    ?>
                    />
                </div>
            <?php endforeach ?>
        <!-- ALPHA ONLY -->
        </fieldset>
        <fieldset name="alphaOnly">
            <legend>Alpha Only</legend>
            <label for="fname">First Name</label>
            <input type="text" id="fname" name="fname" value="<?= $inText ?>"/>
        </fieldset>

        <!-- CHECKBOX -->
        <fieldset>
            <legend>Dropdowns</legend>
            <select name="dropdowns">
                <?php foreach($dropdowns as $key => $value) : ?>
                    <div class="dropdown">
                        <option value="<?= $key ?>"
                            <?php
                                if(isset($inDropDown)){
                                    if($inDropDown == $key) {
                                        echo "selected";
                                    }
                                }
                            ?>
                            ><?= $value ?></option>
                    </div>
                <?php endforeach ?>
            </select>
        </fieldset>

        <!-- RADIO -->
        <fieldset>
            <legend>Radio's</legend>
            <?php foreach($radios as $key => $value) : ?>
                <!-- <div class="radio"> -->
                    <label for="<?= $key ?>"><?= $value ?></label>
                    <input type="radio" id="<?= $key ?>" name="radios" value="<?= $key ?>"
                    <?php
                        if(isset($inRadio)) {
                            if($inRadio == $key) {
                                echo "checked";
                            }
                        }
                     ?>
                    />
                <!-- </div> -->
            <?php endforeach ?>
        </fieldset>
            <button type="submit" name="submit">Get Drinks</button>
     </form>



</main>
