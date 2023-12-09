<?php

namespace Meetanshi\Extensions\Observer;

use Magento\Backend\Model\Auth\Session;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Meetanshi\Extensions\Model\Feed;

/**
 * Class PredispatchAdminActionControllerObserver
 * @package Meetanshi\Extensions\Observer
 */
class PredispatchAdminActionControllerObserver implements ObserverInterface
{

    /**
     * @var Session
     */
    protected $_backendAuthSession;
    /**
     * @var Feed
     */
    protected $feed;

    public function __construct(
        Session $backendAuthSession,
        Feed $feed
    )
    {
        $this->_backendAuthSession = $backendAuthSession;
        $this->feed = $feed;
    }

    public function execute(Observer $observer)
    {
        if ($this->_backendAuthSession->isLoggedIn()) {
            $this->feed->checkUpdate();
        }
    }
}
