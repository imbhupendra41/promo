<?php
namespace Demo\Promo\Helper;

class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ENABLED = 'promo/general/enabled';

    protected $_scopeConfig;

    /**
     * @param \Magento\Framework\App\Helper\Context $context
     */

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Cms\Model\Template\FilterProvider $filterProvider,
        \Magento\Store\Model\StoreManagerInterface $storeManager,
        \Magento\Cms\Model\BlockFactory $blockFactory,
        \Magento\Cms\Model\Page $pageModel,
        \Magento\Framework\App\RequestInterface $requestInterface
    ) {
        $this->_scopeConfig = $context->getScopeConfig();
        parent::__construct($context);
        $this->_filterProvider = $filterProvider;
        $this->_storeManager = $storeManager;
        $this->_blockFactory = $blockFactory;
        $this->pageModel=$pageModel;
        $this->requestInterface=$requestInterface;
    }

    /**
     * Check if enabled
     *
     * @return string|null
     */
    public function isEnabled()
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_ENABLED,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
    }
    /**
     * Get Block Id
     *
     * @return string|null
     */
    public function getBlockId()
    {
        $blockId =  $this->scopeConfig->getValue('promo/general/popup_block',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE);

        return $blockId;
    }

    /**
     * Get Block Title
     *
     * @return string|null
     */
    public function getBlockTitle()
    {

        $blockId = $this->getBlockId();
        $blockTitle =  "";
        if ($blockId) {
            $storeId = $this->_storeManager->getStore()->getId();
            /** @var \Magento\Cms\Model\Block $block */
            $block = $this->_blockFactory->create();
            $block->setStoreId($storeId)->load($blockId);

                $blockTitle = $this->_filterProvider->getBlockFilter()->setStoreId($storeId)->filter($block->getTitle());
        }
        return   $blockTitle;

    }


    /**
     * showPopUp
     *
     * @return string|null
     */
    public function showPopUp()
    {
        $allowedPages = $this->scopeConfig->getValue('promo/general/pages',
        \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        $currCmsPage = $this->pageModel->getIdentifier();
        $moduleName     = $this->requestInterface->getModuleName();
        $pageArr = explode(',',$allowedPages);
        foreach($pageArr as $key => $value){
            if ($moduleName == $value || $currCmsPage == $value) {
                  return "Yes";
            }
        }
    }
    /**
     * Get Height
     *
     * @return string|null
     */
    public function getHeight()
    {
        $height = $this->scopeConfig->getValue(
            'promo/general/popup_height',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($height == "auto") {
            return $height;
        } else {
            return $height."px";
        }
    }

    /**
     * Get Width
     *
     * @return string|null
     */
    public function getWidth()
    {
        $width = $this->scopeConfig->getValue(
            'promo/general/popup_width',
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE
        );
        if ($width == "auto") {
            return $width;
        } else {
            return $width."px";
        }
    }
}
