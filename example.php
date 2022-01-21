<?php
include 'datasanitizer.php'




$Schema = [
    'name' => ['isRequired','isNotSpecial']
    'age' => ['isRequired', 'isNum']
];
$data =[
  'name' =>"Ritesh",
  'age' => '21'
]

$sanitizer = new ValidatorAndSantitzer($Schema);

$sanitizer->dataVaidationAndSanatization($data)

 ?>
