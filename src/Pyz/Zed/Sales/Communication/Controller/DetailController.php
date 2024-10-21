<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\Sales\Communication\Controller;

use Spryker\Zed\Sales\Communication\Controller\DetailController as SprykerDetailController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\Sales\Persistence\SalesRepositoryInterface getRepository()
 * @method \Spryker\Zed\Sales\Business\SalesFacadeInterface getFacade()
 * @method \Pyz\Zed\Sales\Communication\SalesCommunicationFactory getFactory()
 */
class DetailController extends SprykerDetailController
{
    /**
     * @var string
     */
    protected const FAILED_OMS_TRANSITIONS = 'failedOmsTransitions';

 /**
  * @param \Symfony\Component\HttpFoundation\Request $request
  *
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
  */
    public function indexAction(Request $request)
    {
        $response = parent::indexAction($request);
        if (is_array($response)) {
            $response = $this->addFailedOmsTransitionsToResponse($response);
        }

        return $response;
    }

    /**
     * @param array $response
     *
     * @return array
     */
    private function addFailedOmsTransitionsToResponse(array $response): array
    {
        /** @var \Generated\Shared\Transfer\OrderTransfer $orderTransfer */
        $orderTransfer = $response['order'];
        $failedOmsTransitionsTransfer =
            $this->getFactory()->getPyzOmsFacade()->getCurrentFailedTransitionsForIdSalesOrder($orderTransfer->getIdSalesOrder());
        $response[static::FAILED_OMS_TRANSITIONS] = $failedOmsTransitionsTransfer->getOmsTransitionErrors()->getArrayCopy();

        return $response;
    }
}
