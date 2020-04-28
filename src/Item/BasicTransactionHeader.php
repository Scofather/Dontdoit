<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator\Item;

use Brick\Math\BigInteger;
use Clear01\Gpc\Generator\ITransactionGpcItem;
use DateTime;
use DateTimeInterface;
use Money\Money;

class BasicTransactionHeader implements ITransactionGpcItem
{
	const ITEM_TYPE = __CLASS__;

	/** @var BigInteger */
	protected $accountNumber;

	/** @var Money */
	protected $oldAmount;

	/** @var Money */
	protected $newAmount;

	/** @var Money */
	protected $turnoverAmountDebet;

	/** @var Money */
	protected $turnoverAmountCredit;

	/** @var int */
	protected $number;

	/** @var string */
	protected $accountName;

	/** @var DateTimeInterface */
	protected $oldAmountDate;

	/** @var DateTimeInterface */
	protected $date;

	public function __construct(
		BigInteger $accountNumber,
		Money $oldAmount,
		Money $newAmount,
		Money $turnoverAmountDebet,
		Money $turnoverAmountCredit,
		int $number,
		string $accountName = '',
		DateTimeInterface $oldAmountDate = null,
		DateTimeInterface $date = null
	) {

		$this->accountNumber = $accountNumber;
		$this->oldAmount = $oldAmount;
		$this->newAmount = $newAmount;
		$this->turnoverAmountDebet = $turnoverAmountDebet;
		$this->turnoverAmountCredit = $turnoverAmountCredit;
		$this->number = $number;
		$this->accountName = $accountName;
		$this->oldAmountDate = $oldAmountDate ?? new DateTime();
		$this->date = $date ?? new DateTime();
	}


	public function getItemType(): string
	{
		return static::ITEM_TYPE;
	}

	public function getAccountNumber(): BigInteger
	{
		return $this->accountNumber;
	}

	public function getOldAmount(): Money
	{
		return $this->oldAmount;
	}

	public function getNewAmount(): Money
	{
		return $this->newAmount;
	}

	public function getTurnoverAmountDebet(): Money
	{
		return $this->turnoverAmountDebet;
	}

	public function getTurnoverAmountCredit(): Money
	{
		return $this->turnoverAmountCredit;
	}

	public function getNumber(): int
	{
		return $this->number;
	}

	public function getAccountName(): string
	{
		return $this->accountName;
	}

	public function getOldAmountDate(): DateTimeInterface
	{
		return $this->oldAmountDate;
	}

	public function getDate(): DateTimeInterface
	{
		return $this->date;
	}

	public function getPriority(): int
	{
		return 0;
	}
}