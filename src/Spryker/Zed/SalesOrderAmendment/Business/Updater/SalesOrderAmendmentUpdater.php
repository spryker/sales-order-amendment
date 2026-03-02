<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Updater;

use Generated\Shared\Transfer\SalesOrderAmendmentResponseTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentTransfer;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\SalesOrderAmendment\Business\Validator\SalesOrderAmendmentValidatorInterface;
use Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentEntityManagerInterface;

class SalesOrderAmendmentUpdater implements SalesOrderAmendmentUpdaterInterface
{
    use TransactionTrait;

    /**
     * @param \Spryker\Zed\SalesOrderAmendment\Business\Validator\SalesOrderAmendmentValidatorInterface $salesOrderAmendmentValidator
     * @param \Spryker\Zed\SalesOrderAmendment\Persistence\SalesOrderAmendmentEntityManagerInterface $salesOrderAmendmentEntityManager
     * @param list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPreUpdatePluginInterface> $salesOrderAmendmentPreUpdatePlugins
     * @param list<\Spryker\Zed\SalesOrderAmendmentExtension\Dependency\Plugin\SalesOrderAmendmentPostUpdatePluginInterface> $salesOrderAmendmentPostUpdatePlugins
     */
    public function __construct(
        protected SalesOrderAmendmentValidatorInterface $salesOrderAmendmentValidator,
        protected SalesOrderAmendmentEntityManagerInterface $salesOrderAmendmentEntityManager,
        protected array $salesOrderAmendmentPreUpdatePlugins,
        protected array $salesOrderAmendmentPostUpdatePlugins
    ) {
    }

    public function updateSalesOrderAmendment(
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer
    ): SalesOrderAmendmentResponseTransfer {
        $this->assertRequiredFields($salesOrderAmendmentTransfer);

        $salesOrderAmendmentResponseTransfer = $this->salesOrderAmendmentValidator->validate($salesOrderAmendmentTransfer);
        if ($salesOrderAmendmentResponseTransfer->getErrors()->count() > 0) {
            return $salesOrderAmendmentResponseTransfer;
        }

        $salesOrderAmendmentTransfer = $this->getTransactionHandler()->handleTransaction(function () use ($salesOrderAmendmentTransfer) {
            return $this->executeUpdateSalesOrderAmendmentTransaction($salesOrderAmendmentTransfer);
        });

        return $salesOrderAmendmentResponseTransfer->setSalesOrderAmendment($salesOrderAmendmentTransfer);
    }

    protected function executeUpdateSalesOrderAmendmentTransaction(
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer
    ): SalesOrderAmendmentTransfer {
        $salesOrderAmendmentTransfer = $this->executeSalesOrderAmendmentPreUpdatePlugins($salesOrderAmendmentTransfer);
        $salesOrderAmendmentTransfer = $this->salesOrderAmendmentEntityManager->updateSalesOrderAmendment(
            $salesOrderAmendmentTransfer,
        );

        return $this->executeSalesOrderAmendmentPostUpdatePlugins($salesOrderAmendmentTransfer);
    }

    protected function executeSalesOrderAmendmentPreUpdatePlugins(
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer
    ): SalesOrderAmendmentTransfer {
        foreach ($this->salesOrderAmendmentPreUpdatePlugins as $salesOrderAmendmentPreUpdatePlugin) {
            $salesOrderAmendmentTransfer = $salesOrderAmendmentPreUpdatePlugin->preUpdate($salesOrderAmendmentTransfer);
        }

        return $salesOrderAmendmentTransfer;
    }

    protected function executeSalesOrderAmendmentPostUpdatePlugins(
        SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer
    ): SalesOrderAmendmentTransfer {
        foreach ($this->salesOrderAmendmentPostUpdatePlugins as $salesOrderAmendmentPostUpdatePlugin) {
            $salesOrderAmendmentTransfer = $salesOrderAmendmentPostUpdatePlugin->postUpdate($salesOrderAmendmentTransfer);
        }

        return $salesOrderAmendmentTransfer;
    }

    protected function assertRequiredFields(SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer): void
    {
        $salesOrderAmendmentTransfer->requireUuid();
    }
}
