<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator;

use Clear01\Gpc\Generator\Formatter\BasicTransactionHeaderFormatter;
use Clear01\Gpc\Generator\Formatter\BasicTransactionItemFormatter;
use Clear01\Gpc\Generator\Item\BasicTransactionHeader;
use Clear01\Gpc\Generator\Item\BasicTransactionItem;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class GpcBuilderFactory implements IGpcBuilderFactory
{

	/** @var ISOCurrencies */
	protected $isoCurrencies;

	/** @var DecimalMoneyFormatter */
	protected $decimalMoneyFormatter;

	public function __construct(ISOCurrencies $isoCurrencies, DecimalMoneyFormatter $decimalMoneyFormatter)
	{
		$this->isoCurrencies = $isoCurrencies;
		$this->decimalMoneyFormatter = $decimalMoneyFormatter;
	}

	public function create(): GpcBuilder
	{
		return new GpcBuilder([
			BasicTransactionItem::ITEM_TYPE   => new BasicTransactionItemFormatter($this->isoCurrencies, $this->decimalMoneyFormatter),
			BasicTransactionHeader::ITEM_TYPE => new BasicTransactionHeaderFormatter($this->isoCurrencies, $this->decimalMoneyFormatter),
		]);
	}
}