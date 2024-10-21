<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Persistence\Propel\Mapper;

use Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer;
use Generated\Shared\Transfer\OmsTransitionErrorTransfer;

class LogTransitionErrorMapper
{
 /**
  * PDO Associative Result expected with the keys 'fk_sales_order','fk_sales_order_item','error_message','event','source_state'
  *
  * @param array
  *
  * @return \Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer
  */
    public function mapOmsTransitionLogCollectionToOmsTransitionErrorTransfers(
        array $log_errors_pdo_results,
    ): OmsTransitionErrorCollectionTransfer {
        $OmsTransitionErrorCollectionTransfer = new OmsTransitionErrorCollectionTransfer();
        foreach ($log_errors_pdo_results as $log_error_pdo_result) {
            $OmsTransitionErrorCollectionTransfer->addOmsTransitionError($this->mapOmsTransitionLogToOmsTransitionErrorTransfer($log_error_pdo_result));
        }

        return $OmsTransitionErrorCollectionTransfer;
    }

    /**
     * @param array $log_error_pdo_result
     *
     * @return \Generated\Shared\Transfer\OmsTransitionErrorTransfer
     */
    private function mapOmsTransitionLogToOmsTransitionErrorTransfer(array $log_error_pdo_result): OmsTransitionErrorTransfer
    {
        $omsTransitionErrorTransfer = new OmsTransitionErrorTransfer();

        $omsTransitionErrorTransfer->setIdSalesOrder($log_error_pdo_result['fk_sales_order']);
        $omsTransitionErrorTransfer->setIdSalesOrderItem($log_error_pdo_result['fk_sales_order_item']);
        $omsTransitionErrorTransfer->setErrorMessage($log_error_pdo_result['error_message']);
        $omsTransitionErrorTransfer->setSourceState($log_error_pdo_result['source_state']);
        $omsTransitionErrorTransfer->setEvent($log_error_pdo_result['event']);

        return $omsTransitionErrorTransfer;
    }
}
