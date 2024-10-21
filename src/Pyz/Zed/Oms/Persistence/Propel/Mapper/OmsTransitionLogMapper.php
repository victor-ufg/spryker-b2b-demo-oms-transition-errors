<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer;
use Generated\Shared\Transfer\OmsTransitionErrorTransfer;
use Orm\Zed\Oms\Persistence\SpyOmsTransitionLog;
use Propel\Runtime\Collection\Collection;

class OmsTransitionLogMapper
{
 /**
  * PDO Associative Result expected with the keys 'fk_sales_order','fk_sales_order_item','error_message','event','source_state'
  *
  * @param Collection $SpyOmsTransitionLogCollection
  *
  * @return \Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer
  */
    public function collectionToOmsTransitionErrorTransfers(
        Collection $SpyOmsTransitionLogCollection,
    ): OmsTransitionErrorCollectionTransfer {
        $OmsTransitionErrorCollectionTransfer = new OmsTransitionErrorCollectionTransfer();
        foreach ($SpyOmsTransitionLogCollection as $omsTransitionLogEntity) {
            /** @var SpyOmsTransitionLog $omsTransitionLogEntity */
            $OmsTransitionErrorCollectionTransfer->addOmsTransitionError(
                $this->toOmsTransitionErrorTransfer($omsTransitionLogEntity)
            );
        }

        return $OmsTransitionErrorCollectionTransfer;
    }

    /**
     * @param SpyOmsTransitionLog $omsTransitionLogEntity
     *
     * @return \Generated\Shared\Transfer\OmsTransitionErrorTransfer
     */
    public function toOmsTransitionErrorTransfer(SpyOmsTransitionLog $omsTransitionLogEntity): OmsTransitionErrorTransfer
    {
        $omsTransitionErrorTransfer = new OmsTransitionErrorTransfer();

        $omsTransitionErrorTransfer->setIdSalesOrder($omsTransitionLogEntity->getFkSalesOrder());
        $omsTransitionErrorTransfer->setIdSalesOrderItem($omsTransitionLogEntity->getFkSalesOrderItem());
        $omsTransitionErrorTransfer->setErrorMessage($omsTransitionLogEntity->getErrorMessage());
        $omsTransitionErrorTransfer->setSourceState($omsTransitionLogEntity->getSourceState());
        $omsTransitionErrorTransfer->setEvent($omsTransitionLogEntity->getEvent());

        return $omsTransitionErrorTransfer;
    }
}
