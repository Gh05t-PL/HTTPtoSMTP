<?php

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\MissingOptionsException;

/**
 * @Annotation
 */
class StartsWith extends Constraint
{
    /*
     * Any public properties become valid options for the annotation.
     * Then, use these in your validator class.
     */
    public $message = 'The value "{{ value }}" is not valid should start with "{{ text }}".';
    public $text;

    public function __construct($options = null)
    {
	    parent::__construct($options);

	    if (null === $this->text) {
		    throw new MissingOptionsException(sprintf('Option "text" must be given for constraint %s', __CLASS__), ['text']);
	    }
    }
}
