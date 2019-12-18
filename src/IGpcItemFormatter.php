<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator;

interface IGpcItemFormatter
{
	public function format(IGpcItem $item): string;
}