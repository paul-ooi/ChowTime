<?php
    class Validation {
        private $inText;
        private $inCheck;
        private $btnName;

        public function __construct($name1, $name2) {
            // ON SUBMIT
            if(isset($_POST[$btnName])) {
                // CHECK FIELDS AREN'T EMPTY/ASSIGN VALUES
                $this->inText = $this->checkAssignProperty($name1);
                $this->inCheck = $this->checkAssignProperty($name2);
            }
        }

        private function checkAssignProperty($name) {
            if(!empty($_POST[$name])) {
                return $_POST[$name];
            } else {
                return null;
            }
        }
    }



?>
