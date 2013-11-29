<?php
/*
* 2013 Avencall
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to contact@avencall.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author Sylvain Boily <sboily@avencall.com>
*  @copyright  2013 Avencall

*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_CAN_LOAD_FILES_'))
	exit;
	
class blockcustomerxivo extends Module
{
	public function __construct()
	{
		$this->name = 'blockcustomerxivo';
		if(version_compare(_PS_VERSION_, '1.4.0.0') >= 0)
			$this->tab = 'front_office_features';
		else
			$this->tab = 'Blocks';
		$this->version = '1.0';

		parent::__construct();

		$this->displayName = $this->l('XiVO customer info block.');
		$this->description = $this->l('Allows customers to get information on products -- or website content -- on XiVO call center.');
	}
	
	public function install()
	{
		return (parent::install() AND $this->registerHook('extraLeft'));
	}
	
	public function uninstall()
	{
		//Delete configuration			
		return (parent::uninstall() AND $this->unregisterHook(Hook::getIdByName('extraLeft')));
	}
	
	public function hookExtraLeft($params)
	{
		global $smarty, $cookie, $link;		
		
		$id_product = Tools::getValue('id_product');

		if (isset($id_product) && $id_product != '')
		{		
			$product_infos = $this->context->controller->getProduct();
			$smarty->assign(array(
				'product_link' => urlencode($link->getProductLink($product_infos)),
				'product_title' => urlencode($product_infos->name),
            ));

            $this->context->controller->addCSS($this->_path.'blockcustomerxivo.css', 'all');
            $this->context->controller->addJS($this->_path.'blockcustomerxivo.js', 'all');
			return $this->display(__FILE__, 'blockcustomerxivo.tpl');
		} else {
			return '';
		}
	}
}
?>
