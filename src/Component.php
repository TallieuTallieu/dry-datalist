<?php

namespace Tnt\DataList;

abstract class Component
{
	private string $id = '';

	private ?DataList $dataList = null;

	final public function setDataList(DataList $dataList): void
	{
		$this->dataList = $dataList;
	}

	final public function getDataList(): DataList
	{
		if ($this->dataList === null) {
			throw new \RuntimeException('DataList not set on component');
		}
		return $this->dataList;
	}

	final public function setId(string $id): void
	{
		$this->id = $id;
	}

	final public function getId(): string
	{
		return $this->id;
	}
}
