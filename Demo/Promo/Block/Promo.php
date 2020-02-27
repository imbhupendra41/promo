<?php
namespace  Demo\Promo\Block;
use Magento\Framework\View\Element\Template;
class Promo extends Template{
    
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Demo\Promo\Helper\Data $helper,
        array $data = array()
    ) {
        $this->helper = $helper;
        parent::__construct($context, $data);
    }

}