<?php


namespace App\Model;


use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Header\Headers;
use Symfony\Component\Mime\Header\UnstructuredHeader;

class Messages
{
	/**
	 * @var string
	 */
	private $from;
	/**
	 * @var string[]
	 */
	private $to;
	/**
	 * @var string
	 */
	private $title;
	/**
	 * @var string
	 */
	private $body;
	/**
	 * @var UnstructuredHeader[]
	 */
	private $headers;

	/**
	 * @return string
	 */
	public function getFrom(): Address
	{
		return new Address($this->from);
	}

	/**
	 * @param string $from
	 *
	 * @return Messages
	 */
	public function setFrom(string $from): Messages
	{
		$this->from = $from;
		return $this;
	}

	/**
	 * @return Address[]
	 */
	public function getTo(): array
	{
//		$temp = [];
//		foreach ( $this->to as $item ) {
//			$temp []= Address::createArray($this->to);
//		}
		return Address::createArray($this->to);
	}

	/**
	 * @param string[] $to
	 *
	 * @return Messages
	 */
	public function setTo(array $to): Messages
	{
		$this->to = $to;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getTitle(): string
	{
		return $this->title;
	}

	/**
	 * @param string $title
	 *
	 * @return Messages
	 */
	public function setTitle(string $title): Messages
	{
		$this->title = $title;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getBody(): string
	{
		return $this->body;
	}

	/**
	 * @param string $body
	 *
	 * @return Messages
	 */
	public function setBody(string $body): Messages
	{
		$this->body = $body;
		return $this;
	}

	/**
	 * @return Headers[]
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}

	/**
	 * @param Headers[] $headers
	 *
	 * @return Messages
	 */
	public function setHeaders(array $headers): Messages
	{
		$this->headers = $headers;
		return $this;
	}
}