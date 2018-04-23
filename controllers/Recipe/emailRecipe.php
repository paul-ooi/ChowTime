<?php 
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../../vendor/autoload.php';
require '../../models/validation.php';
require '../../models/recipeDB.php';
require '../../models/recipes.php';
require '../../models/db.php';
require '../../models/ingredient.php';
require '../../models/ingredientDB.php';

$v = new Validation();
$db = Database::getDb();
//ON SUBMIT OF EMAIL RECIPE, VALIDATE
if (isset($_POST['emailRecipe'])) {
    $recipe_id = $v->checkAssignProperty('recipe_id');
    $email = $v->checkAssignProperty('toEmail');
    $name = $v->checkAssignProperty('toName');

    if($recipe_id != null) {
        //GET THE RECIPE DETAILS
        $recipes = RecipeDb::displayById($recipe_id);
        $ingredients = IngredientDB::getRecipeIngredients($db, $recipe_id);

        foreach($ingredients as $key => $i) {
            $ingredient .= 
                "<li>
                <span>".$i->quantity."</span>
                <span>".$i->measurement."</span>
                <span>".$i->prep."</span>
                <span>".$i->food_name."</span>";

            if($i->required ==0) {
                $ingredient .= "<span>&lpar;Optional&rpar;</span></li>";
            }
        }

        $title = $recipes->title;
        $descr = $recipes->description;
        $prepTime = $recipes->prep_time;
        $cookTime = $recipes->cook_time;
        $dishLvl = $recipes->dishes_lvl;
        $ingredLvl = $recipes->ingred_lvl;
        $diffLvl = $recipes->diff_lvl;
        $spiceLvl = $recipes->spicy_lvl;
        $steps = $recipes->steps;

        $arrSteps = explode(";", $steps);
        $allSteps = "";
        
        foreach($arrSteps as $step) {
            $allSteps .=  "<li>" . $step . "</li>";
        } 

        $fromAddress = "jessica.pearl.wong@gmail.com";
        $fromName = "Chowtime";
        $subject = "Here's your Chowtime " . $title . " recipe!";
        $body = 
        "<html>
            <h2>".$title."</h2>
            <p>".$descr."</p>
            <p>
                <span>Preparation Time: ".$prepTime."</span>
                <span>Cooking Time: ".$cookTime."</span>
            </p>
            <ul>
                <li>Dish Level: ".$dishLvl."</li>
                <li>Ingredient Level: ".$ingredLvl."</li>
                <li>Difficulty Level: ".$diffLvl."</li>
                <li>Spice Level: ".$spiceLvl."</li>
            </ul>
            <h3>Ingredients</h3>
                <ul>
                    ".$ingredient."
                </ul>
            <h3>Steps</h3>
                <ol>
                    ".$allSteps."
                </ol>
        </html>";
        $isHTML = true;

        try {
            send_email($email, $name, $fromAddress, $fromName, $subject, $body, $isHTML);
            $_SESSION['email_mssg'] = "Your email has been sent.";
            header("Location: ../../pages/recipes.php?&id=" . $recipe_id);
        }
        catch(Exception $e) {            
            $_SESSION['email_mssg'] = $e->getMessage();
            header("Location: ../../pages/recipes.php" . $recipe_id);
        }
    }
    else {
        header("Location: ../../pages/recipes.php" . $recipe_id);
    }
}
else {
    header("Location: ../../pages/recipes.php" . $recipe_id);
}

function send_email($to_address, $to_name, $from_address, $from_name, 
        $subject, $body, $is_body_html = false) {
    if (!valid_email($to_address)) {
        throw new Exception('This To address is invalid: ' .
                            htmlspecialchars($to_address));
    }
    if (!valid_email($from_address)) {
        throw new Exception('This From address is invalid: ' .
                            htmlspecialchars($from_address));
    }

    $mail = new PHPMailer();
    // **** You must change the following to match your
    // **** SMTP server and account information.    
    $mail->isSMTP();                             // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';              // Set SMTP server
    $mail->SMTPSecure = 'tls';                   // Set encryption type
    $mail->Port = 587;                           // Set TCP port
    $mail->SMTPAuth = true;                      // Enable SMTP authentication
    $mail->Username = 'chowtimeauthentication@gmail.com'; // Set SMTP username
    $mail->Password = 'chowtimepass';           // Set SMTP password (ndubhtmajcwysttl)
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );
    // Set From address, To address, subject, and body
    $mail->setFrom($from_address, $from_name);
    $mail->addAddress($to_address, $to_name);
    $mail->Subject = $subject;
    $mail->Body = $body;                  // Body with HTML
    $mail->AltBody = strip_tags($body);   // Body without HTML
    if ($is_body_html) {
        $mail->isHTML(true);              // Enable HTML
    }
    
    if(!$mail->send()) {
        throw new Exception('Error sending email: ' .
                            htmlspecialchars($mail->ErrorInfo) );        
    }    
}

function valid_email($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        return false;
    } else {
        return true;
    }
}

?>

