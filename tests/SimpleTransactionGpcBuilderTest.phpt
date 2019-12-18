<?php
declare(strict_types = 1);

require(__DIR__ . '/../vendor/autoload.php');

use Brick\Math\BigDecimal;
use Clear01\Gpc\Generator\Item\BasicTransactionItem;
use Tester\Assert;

class SimpleTransactionGpcBuilderTest extends Tester\TestCase
{
	/** @var \Clear01\Gpc\Generator\IGpcBuilderFactory */
	protected $builderFactory;

	/** @var \Money\Parser\DecimalMoneyParser */
	protected $moneyParser;

	public function setUp()
	{
		$this->builderFactory = new \Clear01\Gpc\Generator\GpcBuilderFactory(
			$isoCurrencies = new \Money\Currencies\ISOCurrencies(),
			new \Money\Formatter\DecimalMoneyFormatter($isoCurrencies)
		);

		$this->moneyParser = new \Money\Parser\DecimalMoneyParser(
			$isoCurrencies
		);
	}

	public function testBasicTransaction()
	{
		$builder = $this->builderFactory->create();

		$simpleTransactionItem = new BasicTransactionItem(
			BigDecimal::of(1234567890),
			BigDecimal::of(9876543210),
			BasicTransactionItem::SOURCE_ONE_TIME,
			BigDecimal::of(123456),
			$this->moneyParser->parse('1000', 'CZK'),
			BasicTransactionItem::PAYMENT_TYPE_CREDIT,
			BigDecimal::of(4564564),
			300,
			0,
			BigDecimal::of(0),
			new \DateTime('2019-11-18 03:00:00'),
			'TOMAS FUK'
		);

		$builder->addTransaction($simpleTransactionItem);
		$builder->addTransaction($simpleTransactionItem);

		Assert::equal(
			"0750000001234567890000000987654321000000001234560000001000002000456456400030000000000000000181119TOMAS FUK           00203181119" . "\r\n"
			. "0750000001234567890000000987654321000000001234560000001000002000456456400030000000000000000181119TOMAS FUK           00203181119" . "\r\n",
			$builder->getContent()
		);
	}

}

(new SimpleTransactionGpcBuilderTest)->run();
