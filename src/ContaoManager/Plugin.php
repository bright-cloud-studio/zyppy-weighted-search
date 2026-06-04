<?php

/**
 * @copyright  Bright Cloud Studio
 * @author     Bright Cloud Studio
 * @package    bright-cloud-studio/zyppy-weighted-search
 * @license    LGPL-3.0+
 * @see        https://github.com/bright-cloud-studio/zyppy-weighted-search
 */

namespace Bcs\WeightedSearchBundle\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;

class Plugin implements BundlePluginInterface
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create('Bcs\WeightedSearchBundle\BcsWeightedSearchBundle')
                ->setLoadAfter(['Contao\CoreBundle\ContaoCoreBundle', 'Bcs\SearchBundle\BcsSearchBundle']),
        ];
    }
}
