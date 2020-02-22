<?php


namespace App\Utils\Mails;

use App\Model\MailSendRequest;
use Symfony\Component\Mailer\Transport\TransportInterface;
use Symfony\Component\Mime\Email;

class MailService
{
	private $transport;

	public function __construct(
		TransportInterface $transport
	)
	{
		$this->transport = $transport;
	}

	public function setTransport(TransportInterface $transport)
	{
		$this->transport = $transport;
	}

	public function send(MailSendRequest $request)
	{
		$this->transport->send(
			(new Email())
				->from($request->getFrom())
				->to($request->getTo())
				->subject($request->getTitle())
				->text($request->getBody())
		);
	}


}