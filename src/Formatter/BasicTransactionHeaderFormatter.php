<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator\Formatter;

use Brick\Math\BigDecimal;
use Brick\Math\RoundingMode;
use Clear01\Gpc\Generator\IGpcItem;
use Clear01\Gpc\Generator\IGpcItemFormatter;
use Clear01\Gpc\Generator\Item\BasicTransactionHeader;
use Money\Currencies\ISOCurrencies;
use Money\Formatter\DecimalMoneyFormatter;
use function str_pad;

class BasicTransactionHeaderFormatter implements IGpcItemFormatter
{

	/** @var ISOCurrencies */
	protected $isoCurrencies;

	/** @var DecimalMoneyFormatter */
	protected $moneyFormatter;

	protected $contentCode = '074';

	public function __construct(ISOCurrencies $isoCurrencies, DecimalMoneyFormatter $moneyFormatter)
	{
		$this->isoCurrencies = $isoCurrencies;
		$this->moneyFormatter = $moneyFormatter;
	}

	public function format(IGpcItem $item): string
	{
		if (!($item instanceof BasicTransactionHeader)) {
			throw new \InvalidArgumentException();
		}

		$content = $this->contentCode;

		$content .= str_pad((string) $item->getAccountNumber(), 16, '0', STR_PAD_LEFT);
		$content .= str_pad( $item->getAccountName(), 20, ' ', STR_PAD_RIGHT);
		$content .= $item->getOldAmountDate()->format('dmy');
		$content .= str_pad((string) BigDecimal::of($this->moneyFormatter->format($item->getOldAmount()))->multipliedBy(100)->toScale(0, RoundingMode::HALF_UP), 14, '0', STR_PAD_LEFT);
		$content .= $item->getOldAmount()->isNegative() ? '-' : '+';
		$content .= str_pad((string) BigDecimal::of($this->moneyFormatter->format($item->getNewAmount()))->multipliedBy(100)->toScale(0, RoundingMode::HALF_UP), 14, '0', STR_PAD_LEFT);
		$content .= $item->getNewAmount()->isNegative() ? '-' : '+';
		$content .= str_pad((string) BigDecimal::of($this->moneyFormatter->format($item->getTurnoverAmountDebet()))->multipliedBy(100)->toScale(0, RoundingMode::HALF_UP), 14, '0', STR_PAD_LEFT);
		$content .= $item->getTurnoverAmountDebet()->isNegative() ? '-' : '0';
		$content .= str_pad((string) BigDecimal::of($this->moneyFormatter->format($item->getTurnoverAmountCredit()))->multipliedBy(100)->toScale(0, RoundingMode::HALF_UP), 14, '0', STR_PAD_LEFT);
		$content .= $item->getTurnoverAmountCredit()->isNegative() ? '-' : '0';
		$content .= str_pad((string) $item->getNumber(), 3, ' ', STR_PAD_LEFT);

		$content .= $item->getDate()->format('dmy');

		$content .= str_pad('', 14, ' ', STR_PAD_LEFT);

		return $content;
	}
}