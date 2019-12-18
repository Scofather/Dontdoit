<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator\Item;

use Brick\Math\BigDecimal;
use Clear01\Gpc\Generator\ITransactionGpcItem;
use Money\Money;

class BasicTransactionItem implements ITransactionGpcItem
{
	const ITEM_TYPE = self::class;

	const SOURCE_ONE_TIME = 0;
	const SOURCE_RECURRENT = 1;

	const PAYMENT_TYPE_DEBIT = 1;
	const PAYMENT_TYPE_CREDIT = 2;

	/** @var BigDecimal */
	protected $accountNumber;

	/** @var BigDecimal */
	protected $oppositeAccountNumber;

	/** @var int See self::SOURCE_*  */
	protected $source;

	/** @var BigDecimal */
	protected $transactionId;

	/** @var Money */
	protected $amount;

	/** @var int See self::PAYMENT_TYPE_*  */
	protected $paymentType;

	/** @var BigDecimal */
	protected $variableSymbol;

	/** @var int */
	protected $oppositeBankCode;

	/** @var int */
	protected $constantSymbol;

	/** @var BigDecimal */
	protected $specificSymbol;

	/** @var \DateTimeInterface */
	protected $date;

	/** @var string */
	protected $oppositeName;

	public function __construct(
		BigDecimal $accountNumber,
		BigDecimal $oppositeAccountNumber,
		int $source,
		BigDecimal $transactionId,
		Money $amount,
		int $paymentType,
		BigDecimal $variableSymbol,
		int $oppositeBankCode,
		int $constantSymbol,
		BigDecimal $specificSymbol,
		\DateTimeInterface $date,
		string $oppositeName
	) {
		$this->accountNumber = $accountNumber;
		$this->oppositeAccountNumber = $oppositeAccountNumber;
		$this->source = $source;
		$this->amount = $amount;
		$this->paymentType = $paymentType;
		$this->variableSymbol = $variableSymbol;
		$this->oppositeBankCode = $oppositeBankCode;
		$this->constantSymbol = $constantSymbol;
		$this->specificSymbol = $specificSymbol;
		$this->date = $date;
		$this->oppositeName = $oppositeName;
		$this->transactionId = $transactionId;
	}

	public function getAccountNumber(): BigDecimal
	{
		return $this->accountNumber;
	}

	public function getOppositeAccountNumber(): BigDecimal
	{
		return $this->oppositeAccountNumber;
	}

	public function getSource(): int
	{
		return $this->source;
	}

	public function getAmount(): Money
	{
		return $this->amount;
	}

	public function getPaymentType(): int
	{
		return $this->paymentType;
	}

	public function getVariableSymbol(): BigDecimal
	{
		return $this->variableSymbol;
	}

	public function getOppositeBankCode(): int
	{
		return $this->oppositeBankCode;
	}

	public function getConstantSymbol(): int
	{
		return $this->constantSymbol;
	}

	public function getSpecificSymbol(): BigDecimal
	{
		return $this->specificSymbol;
	}

	public function getDate(): \DateTimeInterface
	{
		return $this->date;
	}

	public function getOppositeName(): string
	{
		return $this->oppositeName;
	}

	public function getTransactionId(): BigDecimal
	{
		return $this->transactionId;
	}

	public function getItemType(): string
	{
		return self::ITEM_TYPE;
	}

	public function getPriority(): int
	{
		return 1;
	}
}