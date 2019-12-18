<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator;

interface ITransactionGpcItem extends IGpcItem
{
	/**
	 * @return int Items will be sorted by given priority. Lower number => higher priority
	 */
 	public function getPriority(): int;
}