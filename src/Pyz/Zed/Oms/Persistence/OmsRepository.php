<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Oms\Persistence;

use Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer;
use Orm\Zed\Oms\Persistence\Map\SpyOmsTransitionLogTableMap;
use Orm\Zed\Oms\Persistence\SpyOmsTransitionLogQuery;
use Spryker\Zed\Oms\Persistence\OmsRepository as SprykerOmsRepository;

/**
 * @method \Pyz\Zed\Oms\Persistence\OmsPersistenceFactory getFactory()
 */
class OmsRepository extends SprykerOmsRepository
{
    /**
     * @var int
     */
    public const PDO_FETCH_ASSOC = 2;
    const TABLE_ALIAS_LAST_TRANSITIONS = 'last_transitions';
    const COL_ALIAS_MAX_ID_OMS_TRANSITION_LOG = 'max_id_oms_transition_log';

    /**
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\OmsTransitionErrorCollectionTransfer
     */
    public function getCurrentTransitionErrorsInLogByIdOrder(int $idSalesOrder): OmsTransitionErrorCollectionTransfer
    {

        $lastOmsTransitionLogByOrderItemQuery = $this->buildLastOmsTransitionLogByOrderItemQuery();

        $logByIdOrderQuery = $this->getFactory()
            ->getOmsQueryContainer()
            ->queryLogByIdOrder($idSalesOrder)
            ->addSelectQuery($lastOmsTransitionLogByOrderItemQuery, static::TABLE_ALIAS_LAST_TRANSITIONS, false)
            ->where(sprintf(
                '%s = %s.%s',
                SpyOmsTransitionLogTableMap::COL_ID_OMS_TRANSITION_LOG,
                static::TABLE_ALIAS_LAST_TRANSITIONS,
                static::COL_ALIAS_MAX_ID_OMS_TRANSITION_LOG,
            ));

        $omsTransitionErrorTransfers = $this->getFactory()->createOmsTransitionLogMapper()
            ->collectionToOmsTransitionErrorTransfers($logByIdOrderQuery->findByIsError(true));

        return $omsTransitionErrorTransfers;
    }

    /**
     * @return SpyOmsTransitionLogQuery
     */
    private function buildLastOmsTransitionLogByOrderItemQuery(): SpyOmsTransitionLogQuery
    {
        $lastOmsTransitionLogByOrderItemQuery = SpyOmsTransitionLogQuery::create();
        $lastOmsTransitionLogByOrderItemQuery
            ->addAsColumn(
                'max_id_oms_transition_log',
                sprintf(
                    'MAX(%s)',
                    SpyOmsTransitionLogTableMap::COL_ID_OMS_TRANSITION_LOG,
                )
            )
            ->groupByFkSalesOrder()
            ->groupByFkSalesOrderItem();

        return $lastOmsTransitionLogByOrderItemQuery;
    }
}
