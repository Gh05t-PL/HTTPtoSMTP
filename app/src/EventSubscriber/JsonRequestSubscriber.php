<?php

namespace App\EventSubscriber;

use App\Controller\IJsonRequestController;
use App\Utils\ViolationHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class JsonRequestSubscriber implements EventSubscriberInterface
{
	private $validator;

	public function __construct(ValidatorInterface $validator)
	{
		$this->validator = $validator;
	}

	public function onControllerEvent(ControllerEvent $event)
	{
		/** @var AbstractController $controller */
		$controller = $event->getController();

		if ( is_array($controller) ) {
			$controller = $controller[0];
		}

		if ( $controller instanceof IJsonRequestController ) {
			$violations = $this->validator->validate(
				$event->getRequest()->getContent(),
				new Assert\Json(['message' => "Request should be valid JSON"])
			);

			if ( $violations->count() > 0 ) {
				$event->setController(function () use ($violations) {
					return new JsonResponse([
						'errors' => ViolationHelper::normalizeViolations($violations),
					]);
				});
			}
		}
	}

	public static function getSubscribedEvents()
	{
		return [
			ControllerEvent::class => 'onControllerEvent',
		];
	}
}
