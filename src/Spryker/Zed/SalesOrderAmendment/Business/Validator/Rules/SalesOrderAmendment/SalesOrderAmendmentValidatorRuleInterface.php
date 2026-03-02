<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Validator\Rules\SalesOrderAmendment;

use Generated\Shared\Transfer\ErrorCollectionTransfer;
use Generated\Shared\Transfer\SalesOrderAmendmentTransfer;

interface SalesOrderAmendmentValidatorRuleInterface
{
    public function validate(SalesOrderAmendmentTransfer $salesOrderAmendmentTransfer): ErrorCollectionTransfer;
}
