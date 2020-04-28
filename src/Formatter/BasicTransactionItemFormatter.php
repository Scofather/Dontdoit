<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator\Formatter;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Clear01\Gpc\Generator\IGpcItem;
use Clear01\Gpc\Generator\IGpcItemFormatter;
use Clear01\Gpc\Generator\Item\BasicTransactionItem;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;

class BasicTransactionItemFormatter implements IGpcItemFormatter
{

	/** @var ISOCurrencies */
	protected $isoCurrencies;

	/** @var DecimalMoneyFormatter */
	protected $moneyFormatter;

	protected $contentCode = '075';

	public function __construct(ISOCurrencies $isoCurrencies, DecimalMoneyFormatter $moneyFormatter)
	{
		$this->isoCurrencies = $isoCurrencies;
		$this->moneyFormatter = $moneyFormatter;
	}

	public function format(IGpcItem $item): string
	{
		if (!($item instanceof BasicTransactionItem)) {
			throw new \InvalidArgumentException();
		}

		$content = $this->contentCode;

		$content .= str_pad((string) $item->getAccountNumber(), 16, '0', STR_PAD_LEFT);
		$content .= str_pad((string) $item->getOppositeAccountNumber(), 16, '0', STR_PAD_LEFT);
		$content .= (string) $item->getSource() . str_pad((string) $item->getTransactionId(), 12, '0', STR_PAD_LEFT);
		$content .= str_pad((string) BigDecimal::of($this->moneyFormatter->format($item->getAmount()))->multipliedBy(100)->toScale(0, RoundingMode::HALF_UP), 12, '0', STR_PAD_LEFT);
		$content .= (string) $item->getPaymentType();
		$content .= str_pad((string) $item->getVariableSymbol(), 10, '0', STR_PAD_LEFT);
		$content .= '00';
		$content .= str_pad((string) $item->getOppositeBankCode(), 4, '0', STR_PAD_LEFT);
		$content .= str_pad((string) $item->getConstantSymbol(), 4, '0', STR_PAD_LEFT);
		$content .= str_pad((string) $item->getSpecificSymbol(), 10, '0', STR_PAD_LEFT);
		$content .= $item->getDate()->format('dmy');
		$content .= str_pad($item->getOppositeName(), 20, ' ', STR_PAD_RIGHT);
		$content .= str_pad((string) $this->isoCurrencies->numericCodeFor($item->getAmount()->getCurrency()),
			5,
			'0',
			STR_PAD_LEFT);
		$content .= $item->getDate()->format('dmy');

		return $content;
	}
}