<?php


namespace App\Utils;


use Symfony\Component\Validator\ConstraintViolationListInterface;

class ViolationHelper
{
	static public function normalizeViolations(ConstraintViolationListInterface $violations)
	{
		$formatedViolationList = [];
		for ($i = 0; $i < $violations->count(); $i++) {
			$violation = $violations->get($i);
			$formatedViolationList[] = [
				'property' => $violation->getPropertyPath(),
				'message' => $violation->getMessage(),
				'code' => $violation->getCode()
			];
		}
		return $formatedViolationList;
	}
}