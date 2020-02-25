<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\String\UnicodeString;

class StartsWithValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        /* @var $constraint StartsWith */

        if (null === $value || '' === $value) {
            return;
        }

	    if ( !(new UnicodeString($value))->startsWith($constraint->text) )
	        $this->context->buildViolation($constraint->message)
	            ->setParameter('{{ value }}', $value)
	            ->setParameter('{{ text }}', $constraint->text)
	            ->addViolation();
    }
}
