<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Persistence;

use Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer;
use Spryker\Zed\Oms\Persistence\OmsRepositoryInterface as SprykerOmsRepositoryInterface;

interface OmsRepositoryInterface extends SprykerOmsRepositoryInterface
{
    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer
     */
    public function getCurrentTransitionErrorsInLogByIdOrder(int $idSalesOrder): OmsTransitionErrorCollectionTransfer;
}
