<?php
// OBJECTS
// encapcilization --> hidden implementation
// using access modifiers in object orientated programming, we achieve encapcilization

// inheirent --> parent/child relationship

// Convention: Naming a class, must start with Capital letter, only have one class per file, do not create an instance within that file. (think back to ASP.net)

// Homework: Make a class.

// Starting with a class
class Person {
    // Properties === first provide an access modifier
    private $name = 'Marie'; // Setting a default (althought once adding the __construct, this did not work, I needed to pass in values.)
    const MALE = 'm'; // Constants are unchangable values
    const FEMALE = 'f'; // Constants are named with all caps, always public, no need for access modifier
    private $age;
    private $gender;
    private static $count = 0; // This belongs to the class, not the instance, see below on how it's used.

    // Get/Set Age
    public function setAge($ageParam){
        if($ageParam > 18){
            $this->age = $ageParam;
        }
    }
    public function getAge(){
        return $this->age . " years old.";
    }
    // Get/Set Name
    public function setName($nameParam){
        $this->name = $nameParam;
    }
    public function getName(){
        return $this->name;
    }
    // Get/Set Gender
    public function setGender($genderParam){
        // Will set the value, only if the value passed matches the Constants
        if($gender == self::MALE || $gender == self::FEMALE){
            $this->gender = $genderParam;
        }
    }
    public function getGener(){
        return $this->gender;
    }

    // Constructor
    public function __construct($nameParam, $ageParam){
        $this->setName($nameParam);
        $this->setAge($ageParam);
        self::$count++; // Just to show what the static property works, we are counting how many times this class was used.
    }

    // Methods
    public function displayPerson(){
        // Referring to properties within the object
        return 'Person Class name: ' . $this->getName() . ' | age: ' . $this->getAge();
    }

    public static function getCount(){
        return "The count: " . self::$count; // Showing the static property, this is not for each instance.
    }

    // Destructor
    public function __destruct(){
        // TODO: Implement __destruct() method
        // Not used very often, as it just destroys itself.
    }
} // END OF PERSON CLASS

// Creating a new instance of Person
$p = new Person('Marie', 18);
// Object notation is "->", not "."
echo $p->displayPerson();

//$p->name = 'George'; // When properties have a public access modifier
// Re-assigning the properties
$p->setName('George');
$p->setAge(18);
echo $p->displayPerson();

$p1 = new Person('John', 31);
//$p1->age = "qqqqqqq"; // This is wrong, will throw an error as the $age property is private
$p1->setAge(23);
echo $p1->displayPerson();

echo Person::getCount();
//$p->setGender(gender:Person::FEMALE);



// Personal Example:
class Animal {
    private $species;
    private $name;
    private $age;

    public function setSpecies($speciesParam){
        $this->species = $speciesParam;
    }

    public function getSpecies(){
        return $this->species;
    }

    public function setName($nameParam){
        $this->name = $nameParam;
    }

    public function getName(){
        return $this->name;
    }

    public function setAge($ageParam){
        $this->age = $ageParam;
    }

    public function getAge(){
        return $this->age;
    }

    public function __construct($speciesParam, $nameParam, $ageParam){
        $this->setSpecies($speciesParam);
        $this->setName($nameParam);
        $this->setAge($ageParam);
    }

    public function displayAnimal(){
        return 'Species: ' . $this->getSpecies() . ' | Name: ' . $this->getName() . ' | Age: ' . $this->getAge();
    }
} // END OF ANIMAL CLASS

$a = new Animal('Tiger', 'tiger', 3);

echo $a->displayAnimal();
