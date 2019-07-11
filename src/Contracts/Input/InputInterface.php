<?php

namespace Tnt\DataList\Contracts\Input;

interface InputInterface
{
	public function get(string $key);
	public function has(string $key): bool;
}