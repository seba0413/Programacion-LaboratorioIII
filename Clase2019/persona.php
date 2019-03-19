<?php
include "humano.php"

class Persona extends Humano{

    public $dni;

    function __construct($dni) 
    {
        $this->dni = $dni;
    }

    public virtual function retornarJson(){
        return json_encode($this);
    }
}

?>