<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Creator;

use Generated\Shared\Transfer\SalesOrderAmendmentRequestTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentResponseTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\SalesOrderAmendment\Business\Mapper\SalesOrderAmendmentMapperInterface;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\SalesOrderAmendmentValidatorInterface;
use Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentEntityManagerInterface;

class SalesOrderAmendmentCreator implements SalesOrderAmendmentCreatorInterface
{
    use TransactionTrait;

    /**
     * @param \Spryker\Zed\SalesOrderAmendment\Business\Validator\SalesOrderAmendmentValidatorInterface $salesOrderAmendmentValidator
     * @param \Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentEntityManagerInterface $salesOrderAmendmentEntityManager
     * @param \Spryker\Zed\SalesOrderAmendment\Business\Mapper\SalesOrderAmendmentMapperInterface $salesOrderAmendmentMapper
     * @param list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPreCreatePluginInterface> $salesOrderAmendmentPreCreatePlugins
     * @param list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPostCreatePluginInterface> $salesOrderAmendmentPostCreatePlugins
     */
    public function __construct(
        protected SalesOrderAmendmentValidatorInterface $salesOrderAmendmentValidator,
        protected SalesOrderAmendmentEntityManagerInterface $salesOrderAmendmentEntityManager,
        protected SalesOrderAmendmentMapperInterface $salesOrderAmendmentMapper,
        protected array $salesOrderAmendmentPreCreatePlugins,
        protected array $salesOrderAmendmentPostCreatePlugins
    ) {
    }

    public function createSalesOrderAmendment(
        SalesOrderAmendmentRequestTransfer $salesOrderAmendmentRequestTransfer
    ): SalesOrderAmendmentResponseTransfer {
        $this->assertRequiredFields($salesOrderAmendmentRequestTransfer);

        $salesOrderAmendmentTransfer = $this->salesOrderAmendmentMapper
            ->mapSalesOrderAmendmentRequestTransferToSalesOrderAmendmentTransfer(
                $salesOrderAmendmentRequestTransfer,
                new SalesOrderAmendmentTransfer(),
            );

        $salesOrderAmendmentResponseTransfer = $this->salesOrderAmendmentValidator->validate($salesOrderAmendmentTransfer);
        if ($salesOrderAmendmentResponseTransfer->getErrors()->count() > 0) {
            return $salesOrderAmendmentResponseTransfer;
        }

        $salesOrderAmendmentTransfer = $this->getTransactionHandler()->handleTransaction(function () use ($salesOrderAmendmentTransfer) {
            return $this->executeCreateSalesOrderAmendmentTransaction($salesOrderAmendmentTransfer);
        });

        return $salesOrderAmendmentResponseTransfer->setSalesOrderAmendment($salesOrderAmendmentTransfer);
    }

    protected function executeCreateSalesOrderAmendmentTransaction(
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer
    ): SalesOrderAmendmentTransfer {
        $salesOrderAmendmentTransfer = $this->executeSalesOrderAmendmentPreCreatePlugins($salesOrderAmendmentTransfer);
        $salesOrderAmendmentTransfer = $this->salesOrderAmendmentEntityManager->createSalesOrderAmendment(
            $salesOrderAmendmentTransfer,
        );

        return $this->executeSalesOrderAmendmentPostCreatePlugins($salesOrderAmendmentTransfer);
    }

    protected function executeSalesOrderAmendmentPreCreatePlugins(
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer
    ): SalesOrderAmendmentTransfer {
        foreach ($this->salesOrderAmendmentPreCreatePlugins as $salesOrderAmendmentPreCreatePlugin) {
            $salesOrderAmendmentTransfer = $salesOrderAmendmentPreCreatePlugin->preCreate($salesOrderAmendmentTransfer);
        }

        return $salesOrderAmendmentTransfer;
    }

    protected function executeSalesOrderAmendmentPostCreatePlugins(
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer
    ): SalesOrderAmendmentTransfer {
        foreach ($this->salesOrderAmendmentPostCreatePlugins as $salesOrderAmendmentPostCreatePlugin) {
            $salesOrderAmendmentTransfer = $salesOrderAmendmentPostCreatePlugin->postCreate($salesOrderAmendmentTransfer);
        }

        return $salesOrderAmendmentTransfer;
    }

    protected function assertRequiredFields(SalesOrderAmendmentRequestTransfer $salesOrderAmendmentRequestTransfer): void
    {
        $salesOrderAmendmentRequestTransfer
            ->requireOriginalOrderReference()
            ->requireAmendedOrderReference();
    }
}
