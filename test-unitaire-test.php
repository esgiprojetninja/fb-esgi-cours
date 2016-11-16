<?php
require 'test-unitaire.php';
use PHPUnit\Framework\Calculatrice;
class CalculatriceTest extends Calculatrice
{
  public function test()
  {

    $c = new Calculatrice();
    $this->assertEquals(6, $c->add(0,6));
  }
}
?>
