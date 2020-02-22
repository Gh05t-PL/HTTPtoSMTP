<?php


namespace App\Model;


use Symfony\Component\Mime\Header\Headers;

class MailSendRequest
{
	/**
	 * @var Messages[]
	 */
	private $messages;
	/**
	 * @var string
	 */
	private $dsn;

	/**
	 * @return Messages[]
	 */
	public function getMessages(): array
	{
		return $this->messages;
	}

	/**
	 * @param Messages[] $messages
	 *
	 * @return MailSendRequest
	 */
	public function setMessages(array $messages): MailSendRequest
	{
		$this->messages = $messages;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getDsn(): string
	{
		return $this->dsn;
	}

	/**
	 * @param string $dsn
	 *
	 * @return MailSendRequest
	 */
	public function setDsn(string $dsn): MailSendRequest
	{
		$this->dsn = $dsn;
		return $this;
	}
}