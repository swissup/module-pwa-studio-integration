<?php
declare(strict_types=1);

namespace Swissup\PwaStudioIntegration\Model\Resolver;

use Magento\Framework\GraphQl\Schema\Type\ResolveInfo;
use Magento\Framework\GraphQl\Config\Element\Field;
use Magento\Framework\GraphQl\Exception\GraphQlInputException;
use Magento\Framework\GraphQl\Query\ResolverInterface;

use \Magento\Framework\App\Config\ScopeConfigInterface;
use \Magento\Store\Model\StoreManagerInterface;
use \Magento\Framework\View\Design\Theme\ThemeProviderInterface;

class ThemeDataResolver implements ResolverInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var ThemeProviderInterface
     */
    private $themeProvider;

    /**
     * @var int|null
     */
    private $storeId = null;

    /**
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param ThemeProviderInterface $themeProvider
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        ThemeProviderInterface $themeProvider
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->themeProvider = $themeProvider;
    }

    /**
     * @return \Magento\Framework\View\Design\ThemeInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getTheme()
    {
        $themeId = $this->scopeConfig->getValue(
            \Magento\Framework\View\DesignInterface::XML_PATH_THEME_ID,
            \Magento\Store\Model\ScopeInterface::SCOPE_STORE,
            $this->getStoreId()
        );

        /** @var \Magento\Framework\View\Design\ThemeInterface $theme */
        $theme = $this->themeProvider->getThemeById($themeId);

        return $theme;
    }

    /**
     * @return int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function getStoreId()
    {
        if ($this->storeId === null) {
            $this->storeId = $this->storeManager->getStore()->getId();
        }
        return $this->storeId;
    }

    /**
     * @inheritdoc
     */
    public function resolve(
        Field $field,
              $context,
        ResolveInfo $info,
        array $value = null,
        array $args = null
    ) {
        /** @var \Magento\Theme\Model\Theme $theme */
        $theme = $this->getTheme();
        $data = $theme->getData();
        $data['store_id'] = $this->getStoreId();
        return $data;
    }
}
