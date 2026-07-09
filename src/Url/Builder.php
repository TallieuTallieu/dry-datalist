<?php

namespace Tnt\DataList\Url;

use Tnt\DataList\Contracts\Url\BuilderInterface;

class Builder implements BuilderInterface
{
    private string $base;

    /**
     * @var array<string, string|int|array<string|int>>
     */
    private array $params = [];

    public function __construct(string $base)
    {
        $this->base = $base;
    }

    /**
     * @param string|int|array<string|int> $value
     */
    public function setParam(string $key, string|int|array $value): void
    {
        $this->params[$key] = $value;
    }

    public function withParam(string $key, string|int $value): BuilderInterface
    {
        $clone = clone $this;
        $clone->setParam($key, $value);
        return $clone;
    }

    public function build(): string
    {
        $query = '';

        foreach ($this->params as $param => $value) {
            if (is_array($value)) {
                foreach ($value as $item) {
                    $query .= '&' . $param . '[]=' . $item;
                }
            } else {
                $query .= '&' . $param . '=' . $value;
            }
        }

        return $this->base . '?' . substr($query, 1);
    }
}
