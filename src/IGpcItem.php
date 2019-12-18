<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator;

interface IGpcItem
{
	public function getItemType(): string;
}