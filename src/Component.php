<?php

namespace Tnt\DataList;

abstract class Component
{
	/**
	 * @var string $id
	 */
	private $id;

	/**
	 * @var DataList $dataList
	 */
	private $dataList;

	/**
	 * @param DataList $dataList
	 */
	final public function setDataList(DataList $dataList)
	{
		$this->dataList = $dataList;
	}

	/**
	 * @return DataList
	 */
	final public function getDataList(): DataList
	{
		return $this->dataList;
	}

	/**
	 * @param string $id
	 */
	final public function setId(string $id)
	{
		$this->id = $id;
	}

	/**
	 * @return string $id
	 */
	final public function getId(): string
	{
		return $this->id;
	}
}