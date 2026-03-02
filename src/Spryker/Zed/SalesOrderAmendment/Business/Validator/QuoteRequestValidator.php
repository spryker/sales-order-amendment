<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Spryker\Zed\SalesOrderAmendment\Business\Validator;

use Generated\Shared\Transfer\CartReorderResponseTransfer;
use Generated\Shared\Transfer\CartReorderTransfer;
use Generated\Shared\Transfer\ErrorTransfer;
use Generated\Shared\Transfer\MessageTransfer;
use Generated\Shared\Transfer\QuoteRequestResponseTransfer;
use Generated\Shared\Transfer\QuoteRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Shared\SalesOrderAmendmentExtension\SalesOrderAmendmentExtensionContextsInterface;

class QuoteRequestValidator implements QuoteRequestValidatorInterface
{
    /**
     * @var string
     */
    protected const GLOSSARY_KEY_QUOTE_REQUEST_IN_ORDER_AMENDMENT_IS_FORBIDDEN = 'sales_order_amendment.quote_request.validation.error.forbidden';

    /**
     * @var string
     */
    protected const GLOSSARY_KEY_ORDER_AMENDMENT_AFTER_QUOTE_REQUEST_IS_FORBIDDEN = 'sales_order_amendment.order_amendment_after_rfq.validation.error.forbidden';

    public function validate(QuoteRequestTransfer $quoteRequestTransfer): QuoteRequestResponseTransfer
    {
        $quoteRequestResponseTransfer = (new QuoteRequestResponseTransfer())->setIsSuccessful(true);
        if (!$this->isQuoteRequestReadyForValidation($quoteRequestTransfer)) {
            return $quoteRequestResponseTransfer;
        }

        if ($this->isQuoteInAmendmentProcess($quoteRequestTransfer->getLatestVersionOrFail()->getQuoteOrFail())) {
            return $quoteRequestResponseTransfer
                ->setIsSuccessful(false)
                ->addMessage(
                    (new MessageTransfer())->setValue(static::GLOSSARY_KEY_QUOTE_REQUEST_IN_ORDER_AMENDMENT_IS_FORBIDDEN),
                );
        }

        return $quoteRequestResponseTransfer;
    }

    public function validateCartReorder(
        CartReorderTransfer $cartReorderTransfer,
        CartReorderResponseTransfer $cartReorderResponseTransfer
    ): CartReorderResponseTransfer {
        if (!$cartReorderTransfer->getOrderOrFail()->getQuoteRequestVersionReference()) {
            return $cartReorderResponseTransfer;
        }

        return $cartReorderResponseTransfer->addError(
            (new ErrorTransfer())->setMessage(static::GLOSSARY_KEY_ORDER_AMENDMENT_AFTER_QUOTE_REQUEST_IS_FORBIDDEN),
        );
    }

    protected function isQuoteRequestReadyForValidation(QuoteRequestTransfer $quoteRequestTransfer): bool
    {
        return $quoteRequestTransfer->getLatestVersion() && $quoteRequestTransfer->getLatestVersionOrFail()->getQuote();
    }

    protected function isQuoteInAmendmentProcess(QuoteTransfer $quoteTransfer): bool
    {
        if (
            $quoteTransfer->getQuoteProcessFlow()
            && $quoteTransfer->getQuoteProcessFlowOrFail()->getName() === SalesOrderAmendmentExtensionContextsInterface::CONTEXT_ORDER_AMENDMENT
        ) {
            return true;
        }

        return (bool)$quoteTransfer->getAmendmentOrderReference();
    }
}
