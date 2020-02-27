<?php

namespace Demo\Promo\Setup;

use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;


/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{

    /**
     * @var \Magento\Cms\Model\BlockFactory
     */

    private $blockFactory;

    /**

     * @var \Magento\Cms\Model\BlockRepository
     */
    protected $blockRepository;


    /**
     * Construct
     *
     * @param \Magento\Cms\Model\BlockFactory $blockFactory
     * @param \Magento\Cms\Model\BlockRepository $blockRepository
     */
    public function __construct(
        \Magento\Cms\Model\BlockFactory $blockFactory,
        \Magento\Cms\Model\BlockRepository $blockRepository
    ) {
        $this->blockFactory = $blockFactory;
        $this->blockRepository = $blockRepository;
    }

    /**
     * @param ModuleDataSetupInterface $setup
     * @param ModuleContextInterface $context
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        $blocks = $this->blockFactory;

        $optionsBlock = $blocks->create()->getCollection()->getData();

        $blockIdentifierList = [];
        $blockExist;

        foreach ($optionsBlock as $optinIdfier) {
            $blockIdentifierList[] = $optinIdfier['identifier'];
        }

        if (in_array('promo', $blockIdentifierList)) {
            $blockExist = true;
        } else {
            $blockExist = false;
        }


        if (version_compare($context->getVersion(), '0.0.1') < 0 && $blockExist === false) {
             $testBlock = array(
                            'title' => 'Promo',
                            'identifier' => 'promo',
                            'stores' => array(0),
                            'is_active' => 1,
                            'content' => '<div class="coupon">
                        <div class="container"><img src="{{media url="IMG"}}" alt="" /></div>
                        <img src="{{media url="IMG"}}" alt="Avatar" style="width: 100%;" />
                        <div class="container" style="background-color: white;">
                        <h2><b>20% OFF YOUR PURCHASE</b></h2>
                        <p>Lorem ipsum dolor sit amet, et nam pertinax gloriatur. Sea te minim soleat senserit, ex quo luptatum tacimates voluptatum, salutandi delicatissimi eam ea. In sed nullam laboramus appellantur, mei ei omnis dolorem mnesarchum.</p>
                        </div>
                        <div class="coupon-container">
                        <p>Use Promo Code: <span class="promo">BOH232</span></p>
                        </div>
                        </div>'
                        );

            $this->blockFactory->create()->setData($testBlock)->save();
           
        }

        $setup->endSetup();
    }
}