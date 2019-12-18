<?php
declare(strict_types = 1);

namespace Clear01\Gpc\Generator;

use Clear01\Gpc\Generator\Item\BasicTransactionItem;

class GpcBuilder
{
	/** @var ITransactionGpcItem[][] */
	protected $transactionItems = [];

	/** @var IGpcItemFormatter[] */
	protected $formattersByType = [];

	protected $lineSeparator = "\r\n";

	public function __construct(array $formattersByType)
	{
		$this->formattersByType = $formattersByType;
	}

	public function addTransaction(BasicTransactionItem $item) {
		$this->transactionItems[] = [
			$item
		];
	}

	public function setLineSeparator(string $lineSeparator): void
	{
		$this->lineSeparator = $lineSeparator;
	}

	public function getContent(): string {
		$content = '';

		foreach($this->transactionItems as $transactionItems) {
			usort($transactionItems, function(ITransactionGpcItem $a, ITransactionGpcItem $b) {
				return $a->getPriority() - $b->getPriority();
			});
			foreach($transactionItems as $transactionItem) {
				if(!isset($this->formattersByType[$transactionItem->getItemType()])) {
					throw new \RuntimeException(sprintf('Formatter for item type %s not defined.', $transactionItem->getItemType()));
				}
				$content .= $this->formattersByType[$transactionItem->getItemType()]->format($transactionItem) . $this->lineSeparator;
			}
		}

		return $content;
	}

}