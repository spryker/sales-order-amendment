<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Validator\Util;

use Generated\Shared\Transfer\ErrorCollectionTransfer;
use Generated\Shared\Transfer\ErrorTransfer;

class ErrorAdder implements ErrorAdderInterface
{
    /**
     * @param \Generated\Shared\Transfer\ErrorCollectionTransfer $errorCollectionTransfer
     * @param string $error
     * @param array<string, int|string> $params
     *
     * @return \Generated\Shared\Transfer\ErrorCollectionTransfer
     */
    public function addError(
        ErrorCollectionTransfer $errorCollectionTransfer,
        string $error,
        array $params = []
    ): ErrorCollectionTransfer {
        return $errorCollectionTransfer->addError(
            $this->createErrorTransfer($error, $params),
        );
    }

    /**
     * @param string $error
     * @param array<string, int|string> $parameters
     *
     * @return \Generated\Shared\Transfer\ErrorTransfer
     */
    protected function createErrorTransfer(
        string $error,
        array $parameters = []
    ): ErrorTransfer {
        return (new ErrorTransfer())
            ->setMessage($error)
            ->setParameters($parameters);
    }
}
