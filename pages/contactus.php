<?php

$pageTitle = 'Contact Us';
require_once '_header.php';
require_once '_mainnav.php';
?>
<main class="col-md-8">
    <h1>Contact Us</h1>
    <form action="contactus.php" method="post" name="contact">
        <div class="form-group">
            <label name="cName" for="cName">Name</label>
            <input type="text" name="cName" id="cName" class="form-control"/>
            <label name="err_cName" for="cName" id="err_cName" ></label>
        </div>
        <div class="form-group">
            <label name="cEmail" for="cEmail">Email</label>
            <input type="text" name="cEmail" id="cEmail" class="form-control"/>
            <label name="err_cEmail" for="cEmail" id="err_cEmail" ></label>
        </div>
        <div class="form-group">
            <label name="cIssue" for="cIssue">Reason for request</label>
            <label name="err_cIssue" for="cIssue" id="err_cIssue" ></label>
            <select name="cIssue" id="cIssue" class="form-control">
                <option value="">--Select your reason to contact us--</option>
                <option value="register">How do I register</option>
                <option value="login">Problems loging in</option>
                <option value="recipe">Can&apos;t create recipies</option>
                <option value="tech">Technical Support</option>
                <option value="improve">Suggest Improvement</option>
                <option value="other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label class="contact_form_label contact_form_label_small" name="cFile" for="cFile">Provide a related screenshot <small>(.JPG, .JPEG, .PNG)</small></label>
            <input type="file" name="cFile" id="cFile" accept=".jpg, .jpeg, .png" class="form-control"/>
            <label name="err_cFile" for="cFile" id="err_cFile" ></label>
        </div>
        <div class="form-group">
            <label name="cMsg" for="cMsg">Describe your request</label>
            <textarea name="cMsg" id="cMsg" maxlength="500" class="form-control"></textarea>
            <label name="err_cMsg" for="cMsg" id="err_cMsg" ></label>
        </div>
        <div class="form-group">
            <button type="submit" name="cSubmitBtn" for="contact" class="form-control">Submit</button>
        </div>
    </form>
</main>
<aside class="col-md-4">
    <div id="description">
        <p>Hellow world Lorem ipsum dolor sit amet, eu salutandi constituam conclusionemque vix, has augue senserit petentium in. At pri rebum nulla facilisis. Sit mucius voluptatibus id, sit ne facilisis consequat. Quot deleniti mea in, no has erant possim. In qualisque forensibus est, epicurei patrioque inciderint per cu. Duo in fugit offendit reformidans, te vel prompta menandri.</p>
<p>
Te aperiri vituperatoribus eos, mutat altera est in. Ne usu tollit posidonium assueverit, vix timeam tamquam debitis an. Eum te luptatum reprimique, eos quodsi appetere et, ne aliquam expetendis usu. Omnis tantas mediocritatem ei nec, errem elitr solet sed ne. Cu libris accumsan sed, ex eligendi maluisset mel, cum et amet dicat numquam. Falli impedit dolores te nec, vim at posse everti salutandi.</p>
    </div>
    <div class="office">
    </div>
</aside>
<?php include '_footer.php'?>
<script id="__bs_script__">//<![CDATA[
    document.write("<script async src='http://HOST:3000/browser-sync/browser-sync-client.js?v=2.23.6'><\/script>".replace("HOST", location.hostname));
//]]></script>
</body>
</html>