<?php

namespace Meetanshi\Extensions\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Email\Model\Template\SenderResolver;
use Magento\Framework\Mail\Template\TransportBuilder;
use \Magento\Framework\DataObject;
use \Magento\Framework\App\Area;
use \Magento\Store\Model\Store;

/**
 * Class SendFeedback
 * @package Meetanshi\Extensions\Controller\Adminhtml\Index
 */
class SendFeedback extends Action
{
    /**
     * @var TransportBuilder
     */
    protected $transportBuilder;

    /**
     * @var SenderResolver
     */
    protected $senderResolver;

    /**
     * SendFeedback constructor.
     * @param Context $context
     * @param TransportBuilder $transportBuilder
     * @param SenderResolver $senderResolver
     */
    public function __construct(
        Context $context,
        TransportBuilder $transportBuilder,
        SenderResolver $senderResolver
    ) {
        $this->transportBuilder = $transportBuilder;
        $this->senderResolver = $senderResolver;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $params = $this->getRequest()->getParams();
        $result = [];
        try {
            $senderEmail = $params['email'];
            $senderName = "Meetanshi Extensions";
            $recipientEmail = "help@meetanshi.com";

            $identifier = 'mt_feedback_email_template';

            $requestData = array();

            if ($params['email']) {
                $requestData['email'] = $params['email'];
            }
            if ($params['msg']) {
                $requestData['msg'] = $params['msg'];
            }

            $postObject = new DataObject();
            $postObject->setData($requestData);

            $transport = $this->transportBuilder
                ->setTemplateIdentifier($identifier)
                ->setTemplateOptions(['area' => Area::AREA_FRONTEND, 'store' => Store::DEFAULT_STORE_ID])
                ->setTemplateVars(['data' => $postObject])
                ->setFrom(['name' => $senderName, 'email' => $senderEmail])
                ->addTo([$recipientEmail])
                ->getTransport();
            $transport->sendMessage();

            $result['res'] = 'success';
        } catch (\Exception $e) {
            $result['res'] = 'mailerror - ' . $e->getMessage();
        }

        return $this->getResponse()->representJson(json_encode($result));
    }
}
