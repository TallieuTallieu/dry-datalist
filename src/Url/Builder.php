<?php

namespace Tnt\DataList\Url;

use Tnt\DataList\Contracts\Url\BuilderInterface;

class Builder implements BuilderInterface
{
	/**
	 * @var string $base
	 */
	private $base;

	/**
	 * @var $params
	 */
	private $params = [];

	/**
	 * Builder constructor.
	 * @param string $base
	 */
	public function __construct(string $base)
	{
		$this->base = $base;
	}

	/**
	 * @param string $key
	 * @param string $value
	 */
	public function setParam(string $key, string $value)
	{
		$this->params[$key] = $value;
	}

	/**
	 * @param string $key
	 * @param string $value
	 * @return BuilderInterface
	 */
	public function withParam(string $key, string $value): BuilderInterface
	{
		$clone = clone $this;
		$clone->setParam($key, $value);
		return $clone;
	}

	/**
	 * @return string
	 */
	public function build(): string
	{
		$query = '';

		foreach ($this->params as $param => $value) {
			$query .= '&'.$param.'='.$value;
		}

		return $this->base.'?'.substr($query, 1);
	}
}