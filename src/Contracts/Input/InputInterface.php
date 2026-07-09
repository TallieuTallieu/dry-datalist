<?php

namespace Tnt\DataList\Contracts\Input;

interface InputInterface
{
    public function get(string $key): mixed;
    public function has(string $key): bool;
}
