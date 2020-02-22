<?php


namespace App\Utils;


use App\Validator\StartsWith;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationService
{
	private $constraint;
	private $serializer;
	private $validator;

	public function __construct(
		SerializerInterface $serializer,
		ValidatorInterface $validator
	)
	{
		$this->serializer = $serializer;
		$this->validator = $validator;
	}

	/**
	 * @return mixed
	 */
	public function getConstraint()
	{
		return $this->constraint;
	}

	/**
	 * @param mixed $constraint
	 *
	 * @return ValidationService
	 */
	public function setConstraint($constraint)
	{
		$this->constraint = $constraint;
		return $this;
	}

	public function validate(array $requestData)
	{
		$requestData = $this->serializer->normalize($requestData);

		$violations = $this->validator->validate($requestData,$this->constraint);

		return ViolationHelper::normalizeViolations($violations);
	}
}