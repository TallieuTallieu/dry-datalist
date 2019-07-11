<?php

namespace Tnt\DataList\Contracts\Url;

interface BuilderInterface
{
	public function __construct(string $base);
	public function setParam(string $key, string $value);
	public function withParam(string $key, string $value): BuilderInterface;
	public function build(): string;
}