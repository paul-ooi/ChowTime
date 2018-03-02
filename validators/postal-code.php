<?php
//Paul Ooi
//Postal Code Validator takes in the value from the calling program and compares it to the RegEx of a Canadian postal code to verify input is correct. Returns a Boolean result. The function automatically assumes a null value if there's no value passed to the function and throws an appropriate error.
function postalCode($userInput = null) {
    $result = false;//Set the verification flag to false
    $pcRegex = "/^[A-Z][0-9][A-Z] ?[0-9][A-Z][0-9]$/i"; //Postal Code RegEx with and without the space in the middle, case-insensitive
    try {
        //Catch if there was no argument passed to the function
        if ($userInput == null) {
          throw new ArgumentCountError("There must be a value sent to the validator");
        }
        //Run pattern match and assign boolean to result
        $result = preg_match($pcRegex, $userInput);

    } //End Try Block
      catch (ArgumentCountError $error) {
        return $error->getMessage();
    } catch (Exception $error) {
        //Catch any other error
        echo 'There was an error: ' . $error->getMessage();
    } finally {
        return $result; //Return 1 or 0 for True or False
    }
}//end postalCode function
 ?>
