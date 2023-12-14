<?php

namespace Meetanshi\Extensions\Block\Adminhtml\System\Config;

use \Magento\Config\Block\System\Config\Form\Field;
use \Magento\Framework\Data\Form\Element\AbstractElement;
use \Magento\Framework\App\ObjectManager;

/**
 * Class Extensions
 * @package Meetanshi\Extensions\Block\Adminhtml\System\Config
 */
class Extensions extends Field
{
    /**
     * @var string
     */
    protected $_template = 'system/config/advance/extensions.phtml';

    /**
     * @param AbstractElement $element
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $columns = $this->getRequest()->getParam('website') || $this->getRequest()->getParam('store') ? 5 : 4;
        return $this->_decorateRowHtml($element, "<td colspan='{$columns}'>" . $this->toHtml() . '</td>');
    }

    /**
     * @return array
     */
    public function getModulesList()
    {
        $om = ObjectManager::getInstance();
        $moduleList = $om->get('\Magento\Framework\Module\FullModuleList');
        $mList = $moduleList->getAll();
        $modules = [];

        $curl = $om->get('\Magento\Framework\HTTP\Client\Curl');
        $target_url = base64_decode('aHR0cHM6Ly9tZWV0YW5zaGkuY29tL2V4dGVuc2lvbnMuanNvbg');
        $curl->get($target_url);

        $data = $curl->getBody();
        $data = json_decode($data, true);

        foreach ($mList as $m) {
            if (strpos($m['name'], 'Meetanshi') !== false) {
                if (array_key_exists($m['name'], $data)) {
                    $ext_name = str_replace('_', ' ', $m['name']);
                    $modules[] = [
                        'name' => $ext_name,
                        'cVer' => $m['setup_version'],
                        'data' => $data[$m['name']]
                    ];
                }
            }
        }

        return $modules;
    }
}