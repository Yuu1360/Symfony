<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsValidNumeroTelefono extends Constraint 
{
    public $mensage = "El numero de telefono {{ value }} no es valido";
}
