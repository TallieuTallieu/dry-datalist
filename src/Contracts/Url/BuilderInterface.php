<?php

namespace Tnt\DataList\Contracts\Url;

interface BuilderInterface
{
	public function __construct(string $base);

	/**
	 * @param string|int|array<string|int> $value
	 */
	public function setParam(string $key, string|int|array $value): void;

	public function withParam(string $key, string|int $value): BuilderInterface;

	public function build(): string;
}
