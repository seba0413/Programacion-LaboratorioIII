<?php
include "persona.php";

class Alumno extends Persona{
  
    public $legajo;

    function __construct($legajo) 
    {
        $this->legajo = $legajo;
    }

    public override function retornarJson(){
        return json_encode($this);
    }
}
?>