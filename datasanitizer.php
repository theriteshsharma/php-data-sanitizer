<?php
class ValidatorAndSantitzer{
  private $Schema

  function __construct($Schema){
    $this->$Schema = $Schema;
  }
  function showSchema(){
    return $this->$Schema;
  }

  function  tableValidation($data, $schema)
  {
      $header = $data[0];
      $tabdata = array_slice($data, 1);
      $error = [];
      $resError = [];
      foreach ($tabdata as $row_num => $row) {
          $resError = dataVaidationAndSanatization($row, $schema);
          if (!empty($resError)) {
              $error[$row_num] = $resError;
          };
      }
      return $error;
  }

  function dataVaidationAndSanatization($data)
  {
      $errors = [];
      foreach ($Schema as $key => $rules) {
          $errorInKey = 0;
          $errorMsg = "";
          foreach ($rules as $rule) {
              if (is_Array($rule)) {
                  $temp = tableValidation($data[$key], $rule);
                  if (!empty($temp))
                      $errors[$key] = $temp;
              } else
                  switch ($rule) {
                      case 'isRequired':
                          if (!array_key_exists($key, $data) || $data[$key] == '') {
                              $errorInKey = 1;
                              $errorMsg .= "$key is required";
                          }
                          break;
                      case 'isNum':
                          if (!is_numeric((int)$data[$key])) {
                              $errorInKey = 1;
                              $errorMsg .= "$key Should be Number";
                          } else {
                              $data[$key] = (int)$data[$key];
                          }
                          break;
                      case 'isNotSpecial':
                          if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $data[$key])) {
                              $errorInKey = 1;
                              $errorMsg .= "$key  Should not Contain Special Charachter";
                          }
                          break;
                      case 'isPositive':
                          if ((int)$data[$key] <= 0) {
                              $errorInKey = 1;
                              $errorMsg .= "$key Should be a positive number";
                          }
                          break;
                      case 'isTable':
                          if (!is_Array($data[$key])) {
                              print_r($data[$key]);
                              $errorInKey = 1;
                              $errorMsg .= "$key Should be a table";
                          }
                          break;
                      case '':
                          break;
                      default:
                          $errors['Schema Error'] = "Invalid Schema Constrain for $key";
                          break;
                  }
              if ($errorInKey) {
                  $errors[$key] = $errorMsg;
                  break;
              }
          }
      }
      return $errors;
  }



}

?>


$blueprint = [
    'name' => ['isRequired','isNotSpecial']
];



$schema = [
    'TABLE' => [
        'isRequired', 'isTable',

        [
            '0' => ['isRequired'],
            '1' => ['isRequired', 'isNum'],
            '2' => ['isRequired'],
            '3' => ['isRequired'],
            '4' => ['isRequired'],
            '5' => ['isRequired']
        ]
    ]
];
