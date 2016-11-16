<?php

class Calculatrice{

  public function add($a,$b){
    return $a+$b;
  }

  public function sub($a,$b){
    return $a-$b;
  }

  public function mul($a,$b){
    return $a*$b;
  }

  public function div($a,$b){
    return $a/$b;
  }

  public function avg($a){
    $moyenne=0;
    foreach($a as $note)
    {
      $moyenne+=$note;
    }
    return $moyenne/count($a);
  }

}

?>
