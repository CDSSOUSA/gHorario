<?php

namespace App\Validation;

use App\Models\TeacDiscModel;

class CustomRules
{

  // Rule is to validate mobile number digits
  public function mobileValidation(string $str, string $fields, array $data)
  {

    /*Checking: Number must start from 5-9{Rest Numbers}*/
    if (preg_match('/^[5-9]{1}[0-9]+/', $data['mobile'])) {

      /*Checking: Mobile number must be of 10 digits*/
      $bool = preg_match('/^[0-9]{10}+$/', $data['mobile']);
      return $bool == 0 ? false : true;
    } else {

      return false;
    }
  }

  public function disciplineValidationDuplicate(string $str, string $fields, array $data)
  {
   
    $teacDisc = new TeacDiscModel();

    $result = $teacDisc->getDisciplineValidationDuplicate($data['disciplinesTeacher']);

    if ($result >= 0) {
      return true;
    }
    return false;
  }
}
