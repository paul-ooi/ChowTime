<?php
    
    if (isset($_POST['cSubmitBtn'])) {
        require_once "../models/db.php";
        require_once "../models/validation.php";
        require_once "../models/ticket.php";
        require_once "../models/profile.php";
        require_once "../models/ticketDB.php";
        require_once "check-ticket.php";


    }
    
?>

<main class="col-lg-8">
    <h1>Contact Us</h1>
    <form action="contactus.php" method="post" name="contact">
    <!-- DEFAULT SHOULD BE CONACT FORM FOR EXISTING USERS, LATER INCORPORATE ANON USERS -->
        <!-- <div class="form-group">
            <label name="cName" for="cName" class="required">Name</label>
            <input type="text" name="cName" id="cName" class="form-control"/>
            <label name="err_cName" for="cName" id="err_cName" ></label>
        </div>
        <div class="form-group">
            <label name="cEmail" for="cEmail" class="required">Email</label>
            <input type="text" name="cEmail" id="cEmail" class="form-control"/>
            <label name="err_cEmail" for="cEmail" id="err_cEmail" ></label>
        </div> -->
        <div class="form-group">
            <label name="cIssue" for="cIssue" class="required">Reason for request</label>
            <label name="err_cIssue" for="cIssue" id="err_cIssue" ></label>
            <select name="cIssue" id="cIssue" class="form-control">
                <option value="">--Select your reason to contact us--</option>
                <option value="register">How do I register</option>
                <option value="login">Problems loging in</option>
                <option value="recipe">Can&apos;t create recipies</option>
                <option value="technical">Technical Support</option>
                <option value="suggestion">Suggest Improvement</option>
                <option value="inquiry">Other</option>
            </select>
        </div>
        <!-- FUTURE VERSION OF FORM TO INCLUDE SCREENSHOT UPLOAD -->
        <!-- <div class="form-group">
            <label class="contact_form_label contact_form_label_small" name="cFile" for="cFile">Provide a related screenshot <small>(.JPG, .JPEG, .PNG)</small></label>
            <input type="file" name="cFile" id="cFile" accept=".jpg, .jpeg, .png" class="form-control"/>
            <label name="err_cFile" for="cFile" id="err_cFile" ></label>
        </div> -->
        <div class="form-group">
            <label name="cMsg" for="cMsg">Describe your request</label>
            <textarea name="cMsg" id="cMsg" maxlength="500" class="form-control"></textarea>
            <label name="err_cMsg" for="cMsg" id="err_cMsg" ></label>
        </div>
        <div class="input-group-btn">
            <button type="submit" name="cSubmitBtn" for="contact" class="btn btn-primary">Submit</button>
        </div>
    </form>
</main>
<aside class="col-lg-4" id="description">
    <div>
        <p>Description of our company Lorem ipsum dolor sit amet, eu salutandi constituam conclusionemque vix, has augue senserit petentium in. At pri rebum nulla facilisis. Sit mucius voluptatibus id, sit ne facilisis consequat. Quot deleniti mea in, no has erant possim. In qualisque forensibus est, epicurei patrioque inciderint per cu. Duo in fugit offendit reformidans, te vel prompta menandri.</p>
<p>
Te aperiri vituperatoribus eos, mutat altera est in. Ne usu tollit posidonium assueverit, vix timeam tamquam debitis an. Eum te luptatum reprimique, eos quodsi appetere et, ne aliquam expetendis usu. Omnis tantas mediocritatem ei nec, errem elitr solet sed ne. Cu libris accumsan sed, ex eligendi maluisset mel, cum et amet dicat numquam. Falli impedit dolores te nec, vim at posse everti salutandi.</p>
    </div>
    <div class="office">
    </div>
</aside>
