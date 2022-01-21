<?php
include 'datasanitizer.php'




$Schema = [
    'name' => ['isRequired','isNotSpecial']
    'age' => ['isRequired', 'isNum']
];


$sanitizer = new ValidatorAndSantitzer($Schema);





 ?>
