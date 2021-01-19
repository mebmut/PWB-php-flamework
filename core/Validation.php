<?php
namespace Core;

use Exception;

class Validation{

	public $success=true, $msg='', $field, $additionalFieldData=[],$rule;
	protected $_model;

 public function __construct($model,$validate,$field,$rule='',$msg=''){
  $fieldName = explode('@', $field);
 	$this->_model = $model;
 	$this->validate = $validate;
 	$this->field = $fieldName[0];
 	$this->rule = $rule;
	$this->msg = $msg;
  $this->fieldName = ucwords(end($fieldName));
	 if(!property_exists($this->_model, $this->field)){
		throw new Exception("The field must exist in the model");
	  }
    try {
      $this->success = $this->$validate();
    } catch(Exception $e) {
      echo "Validation Exception on " . get_class() . ": " . $e->getMessage() . "<br />";
    }
 	
 }

 public function min(){
 	$msg = $this->fieldName.' must be more than '.$this->rule.' characters! ';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 	$value = $this->_model->{$this->field};
	return (strlen($value) >= $this->rule);
 }

 public function max(){
  $msg = $this->fieldName.' must be less than '.$this->rule.' characters! ';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 	$value = $this->_model->{$this->field};
 	return (strlen($value) <= $this->rule);
 }

 public function unique(){
 	$msg = $this->fieldName.' must be unique {'.$this->_model->{$this->field}.'} already exists';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
    $value = $this->_model->{$this->field};

    if($value == '' || !isset($value)){
      // this allows unique validator to be used with empty strings for fields that are not required.
      return true;
    }

    $conditions = ["{$this->field} = ?"];
    $bind = [$value];

    if (!empty($this->rule)&&is_array($this->rule)) {
      if (array_key_exists('conditions', $this->rule)) {
        $conditions[] = $this->rule['conditions'];
      }
      if (array_key_exists('bind', $this->rule)) {
        $bind[] = $this->rule['bind'];
      }
    }

    //check updating record
    if(!empty($this->_model->id)){
      $conditions[] = "id != ?";
      $bind[] = $this->_model->id;
    }

    // this allows you to check multiple fields for Unique
    foreach($this->additionalFieldData as $adds){
      $conditions[] = "{$adds} = ?";
      $bind[] = $this->_model->{$adds};
    }
    $queryParams = ['conditions'=>$conditions,'bind'=>$bind];
    $other = $this->_model::findFirst($queryParams);
    return(!$other);
 }

 public function numeric(){
  $msg = $this->fieldName.' field must contain numbers only! ';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 	return (is_numeric($this->_model->{$this->field}));
 }

 public function string(){
  $msg = $this->fieldName.' field  must contain a string! ';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 	return (is_string($this->_model->{$this->field}));
 }

 public function email(){
 	$msg = $this->fieldName.' field must contain a valid email! ';
	 $this->msg = (!empty($this->msg)) ? $this->msg : $msg;
	 $email = $this->_model->{$this->field};
	 $pass = true;
	 if(!empty($email)){
	   $pass = filter_var($email, FILTER_VALIDATE_EMAIL);
	 }
	 return $pass;
 }

 public function required(){
  $msg = $this->fieldName.' can not be empty! ';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 	return (!empty($this->_model->{$this->field})); 
 }

 public function website(){
  $msg = $this->fieldName.' must contain a valid website!';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 }

 public function equal(){
 	$msg = ucwords($this->field).' must be equal to '.$this->fieldName;
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 	$value = $this->_model->{$this->field};
  if ($this->rule=='confirm') {
    $this->rule = $this->_model->confirm;
  }
 	return ($value === $this->rule);
 }

 public function cellphone(){
  $msg = $this->fieldName.' must be a valid cellphone number ';
  $this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 }

 public function capitalized(){
 	$msg = $this->fieldName.' must be in CAPITAL LETTERS ';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 }

 public function hasCapital(){
 	$msg = $this->fieldName.' must contain at least '.$this->rule.' CAPITAL LATTER[S] ';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 }

 public function characters (){
 	$msg = $this->fieldName.' must contain at least '.$this->rule.' special characters!  [%,@,&,/,\,^,!] ';
 	$this->msg = (!empty($this->msg)) ? $this->msg : $msg;
 }

 public function fileExists (){
  $msg = $this->fieldName.' already exists';
  $this->msg = (!empty($this->msg)) ? $this->msg : $msg;
  return (!file_exists($this->rule));
}
}
