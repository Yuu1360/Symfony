<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class IsValidNumeroTelefonoValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if ($value === null || $value === '') {
            return;
        }

        if(strlen($value) !== 12 && strlen($value) !== 13){
            $this->context->buildViolation($constraint->mensage)
                ->setParameter("{{ value }}", $value)
                ->addViolation();

            return;
        }

        if(substr($value, 0, 1) !== '+'){
            $this->context->buildViolation($constraint->mensage)
                ->setParameter("{{ value }}", $value)
                ->addViolation();

            return;
        }

        if (!is_numeric(substr($value, 1))) {
            $this->context->buildViolation($constraint->mensage)
                ->setParameter("{{ value }}", $value)
                ->addViolation();
        }
    }
}
