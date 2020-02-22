<?php

namespace App\Controller;

use App\Model\MailSendRequest;
use App\Utils\ValidationService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\Transport;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class MailCatcherController extends AbstractController implements IJsonRequestController
{
	/**
	 * @Route("/v1/mail/catcher")
	 * @param ValidationService $requestValidator
	 * @param Request $request
	 * @param SerializerInterface $serializer
	 *
	 * @return \Symfony\Component\HttpFoundation\JsonResponse
	 * @throws \Symfony\Component\Mailer\Exception\TransportExceptionInterface
	 */
	public function mailCatcher(
		ValidationService $requestValidator,
		Request $request,
		SerializerInterface $serializer
	)
	{
		$requestData = json_decode($request->getContent(), true);

		$requestValidator->setConstraint($this->getMailCatcherRequestConstraint());

		$violations = $requestValidator->validate($requestData);
		if ( count($violations) > 0 )
			return $this->json([
				'errors' => $violations,
			]);


		dump($requestData);

		/** @var $requestObject MailSendRequest */
		$requestObject = $serializer->denormalize($requestData, MailSendRequest::class);

		dump($requestObject->getMessages());

		/** @var Transport\Smtp\SmtpTransport $transport */
		$transport = Transport::fromDsn($requestObject->getDsn());

		dump($requestObject);

		foreach ( $requestObject->getMessages() as $message ) {
			$a = (new Email())
				->from($message->getFrom())
				->bcc(...$message->getTo())
				->subject($message->getTitle())
				->text($message->getBody());
//				    ->html($message->getBody())

			dump($a->getHeaders(), 'a');
			try {
				if ( !empty($message->getHeaders()) ) {
					$a->setHeaders($a->getHeaders()->add(...$message->getHeaders()));
				}
			} catch ( \LogicException $e ) {
				return $this->json([
					'errors' => [$e->getMessage(), $e->getCode()],
				]);
			}

			dump($transport->send(
				$a
			));
		}

		return $this->json([
			'message' => '',
		]);
	}

	private function getMailCatcherRequestConstraint()
	{
		return new Assert\Collection([
			'messages' => [
				new Assert\NotBlank(),
				new Assert\Count(['min' => 1]),
				new Assert\All([
					new Assert\Collection([
						'from' => [
							new Assert\NotBlank(),
							new Assert\Type('string'),
							new Assert\Email()
						],
						'to' => [
							new Assert\NotBlank(),
							new Assert\Count(['min' => 1]),
							new Assert\All([
								new Assert\Type('string'),
								new Assert\Email()
							])
						],
						'title' => [
							new Assert\NotBlank(),
							new Assert\Type('string')
						],
						'body' => [
							new Assert\NotBlank(),
							new Assert\Type('string')
						],
						'headers' => [
							new Assert\Type('array')
						],
					])
				])
			],
			'dsn' => [
				new Assert\NotBlank(),
				new Assert\Type('string'),
				new Assert\Url([
					'protocols' => ['smtp']
				])
			],
		]);
	}

}
