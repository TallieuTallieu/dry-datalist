<?php

namespace Tnt\DataList\Input;

use Tnt\DataList\Contracts\Input\InputInterface;

class GetParams implements InputInterface
{
	public function get(string $key)
	{
		return $_GET[$key];
	}

	public function has(string $key): bool
	{
		return isset($_GET[$key]);
	}
}