<?php

namespace Tnt\DataList;

use Oak\Contracts\Container\ContainerInterface;
use Oak\ServiceProvider;
use Tnt\DataList\Contracts\DataListInterface;
use Tnt\DataList\Contracts\Input\InputInterface;
use Tnt\DataList\Contracts\Url\BuilderInterface;
use Tnt\DataList\Input\GetParams;
use Tnt\DataList\Url\Builder;

class DataListServiceProvider extends ServiceProvider
{
	public function boot(ContainerInterface $app)
	{
		// TODO: Implement boot() method.
	}

	public function register(ContainerInterface $app)
	{
		$app->set(BuilderInterface::class, Builder::class);
		$app->set(DataListInterface::class, DataList::class);
		$app->set(InputInterface::class, GetParams::class);
	}
}