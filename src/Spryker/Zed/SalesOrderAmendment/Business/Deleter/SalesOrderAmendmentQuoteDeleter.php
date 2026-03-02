<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Deleter;

use Generated\Shared\Transfer\SalesOrderAmendmentQuoteCollectionDeleteCriteriaTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentQuoteCollectionResponseTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentQuoteCollectionTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentQuoteCriteriaTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\SalesOrderAmendment\Business\Mapper\SalesOrderAmendmentQuoteCriteriaMapperInterface;
use Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentEntityManagerInterface;
use Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentRepositoryInterface;

class SalesOrderAmendmentQuoteDeleter implements SalesOrderAmendmentQuoteDeleterInterface
{
    use TransactionTrait;

    public function __construct(
        protected SalesOrderAmendmentRepositoryInterface $salesOrderAmendmentRepository,
        protected SalesOrderAmendmentEntityManagerInterface $salesOrderAmendmentEntityManager,
        protected SalesOrderAmendmentQuoteCriteriaMapperInterface $salesOrderAmendmentQuoteCriteriaMapper
    ) {
    }

    public function deleteSalesOrderAmendmentQuoteCollection(
        SalesOrderAmendmentQuoteCollectionDeleteCriteriaTransfer $salesOrderAmendmentQuoteCollectionDeleteCriteriaTransfer
    ): SalesOrderAmendmentQuoteCollectionResponseTransfer {
        $salesOrderAmendmentQuoteCriteriaTransfer = $this->salesOrderAmendmentQuoteCriteriaMapper
            ->mapSalesOrderAmendmentQuoteCollectionDeleteCriteriaTransferToSalesOrderAmendmentQuoteCriteriaTransfer(
                $salesOrderAmendmentQuoteCollectionDeleteCriteriaTransfer,
                new SalesOrderAmendmentQuoteCriteriaTransfer(),
            );

        $salesOrderAmendmentQuoteCollectionTransfer = $this->salesOrderAmendmentRepository->getSalesOrderAmendmentQuoteCollection($salesOrderAmendmentQuoteCriteriaTransfer);
        if ($salesOrderAmendmentQuoteCollectionTransfer->getSalesOrderAmendmentQuotes()->count() === 0) {
            return new SalesOrderAmendmentQuoteCollectionResponseTransfer();
        }

        return $this->getTransactionHandler()->handleTransaction(function () use ($salesOrderAmendmentQuoteCollectionTransfer) {
            return $this->executeDeleteSalesOrderAmendmentQuoteCollectionTransaction($salesOrderAmendmentQuoteCollectionTransfer);
        });
    }

    protected function executeDeleteSalesOrderAmendmentQuoteCollectionTransaction(
        SalesOrderAmendmentQuoteCollectionTransfer $salesOrderAmendmentQuoteCollectionTransfer
    ): SalesOrderAmendmentQuoteCollectionResponseTransfer {
        $salesOrderAmendmentQuoteIds = $this->extractSalesOrderAmendmentQuoteIdsFromSalesOrderAmendmentQuoteCollection($salesOrderAmendmentQuoteCollectionTransfer);
        $this->salesOrderAmendmentEntityManager->deleteSalesOrderAmendmentQuotes($salesOrderAmendmentQuoteIds);

        return (new SalesOrderAmendmentQuoteCollectionResponseTransfer())
            ->setSalesOrderAmendmentQuotes($salesOrderAmendmentQuoteCollectionTransfer->getSalesOrderAmendmentQuotes());
    }

    /**
     * @param \Generated\Shared\Transfer\SalesOrderAmendmentQuoteCollectionTransfer $salesOrderAmendmentQuoteCollectionTransfer
     *
     * @return list<int>
     */
    protected function extractSalesOrderAmendmentQuoteIdsFromSalesOrderAmendmentQuoteCollection(
        SalesOrderAmendmentQuoteCollectionTransfer $salesOrderAmendmentQuoteCollectionTransfer
    ): array {
        $salesOrderAmendmentQuoteIds = [];
        foreach ($salesOrderAmendmentQuoteCollectionTransfer->getSalesOrderAmendmentQuotes() as $salesOrderAmendmentQuoteTransfer) {
            $salesOrderAmendmentQuoteIds[] = $salesOrderAmendmentQuoteTransfer->getIdSalesOrderAmendmentQuoteOrFail();
        }

        return $salesOrderAmendmentQuoteIds;
    }
}
