<?php
/**
 *
 * @package Lillik\PriceDecimal\Model\Plugin
 *
 * @author  Lilian Codreanu <lilian.codreanu@gmail.com>
 */

namespace Lillik\PriceDecimal\Model\Plugin;

class PriceCurrency extends PriceFormatPluginAbstract
{

    /**
     * {@inheritdoc}
     */
    public function aroundFormat(
        \Magento\Directory\Model\PriceCurrency $subject,
        callable $proceed,
        ...$args
    ) {

        if ($this->getConfig()->isEnable()) {

            if(!isset($args[1])){
                $args[1] = true;
            }

            $args[2] = $this->getPricePrecision(); // Precision argument
        }

        return $proceed(...$args);
    }
    
    public function beforeConvertAndRound(
        $subject,
        $amount,
        $scope = null,
        $currency = null,
        $precision = \Magento\Directory\Model\PriceCurrency::DEFAULT_PRECISION
    ) {
        return [$amount, $scope, $currency, $this->getPricePrecision()];
    }

    /**
     * {@inheritdoc}
     */
    public function aroundRound(
        \Magento\Directory\Model\PriceCurrency $subject,
        callable $proceed,
        ...$args
    ) {
        return round($args[0], $this->getPricePrecision());
    }   
}
