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

include_once('lib/Ajam.php');
	
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
		return (parent::install() AND Configuration::updateValue('blockcustomerxivo_xivo_url', '') && 
                                      Configuration::updateValue('blockcustomerxivo_login', '') && 
                                      Configuration::updateValue('blockcustomerxivo_secret', '') && 
                                      Configuration::updateValue('blockcustomerxivo_outcontext', '') && 
                                      Configuration::updateValue('blockcustomerxivo_exten', '') && 
                                      Configuration::updateValue('blockcustomerxivo_context', '') && 
                                      $this->registerHook('displayLeftColumnProduct'));
	}
	
	public function uninstall()
	{
		//Delete configuration			
		return (parent::uninstall() AND Configuration::deleteByName('blockcustomerxivo_xivo_url') 
                                    AND Configuration::deleteByName('blockcustomerxivo_login') 
                                    AND Configuration::deleteByName('blockcustomerxivo_secret') 
                                    AND Configuration::deleteByName('blockcustomerxivo_outcontext') 
                                    AND Configuration::deleteByName('blockcustomerxivo_exten') 
                                    AND Configuration::deleteByName('blockcustomerxivo_context') 
                                    AND $this->unregisterHook(Hook::getIdByName('displayLeftColumnProduct')));
	}

	public function getContent()
	{
		$output = '';
		if (isset($_POST['submitModule']))
		{   
			Configuration::updateValue('blockcustomerxivo_xivo_url', (($_POST['xivo_url'] != '') ? $_POST['xivo_url']: ''));
			Configuration::updateValue('blockcustomerxivo_login', (($_POST['login'] != '') ? $_POST['login']: ''));     
			Configuration::updateValue('blockcustomerxivo_secret', (($_POST['secret'] != '') ? $_POST['secret']: ''));             
			Configuration::updateValue('blockcustomerxivo_outcontext', (($_POST['outcontext'] != '') ? $_POST['outcontext']: ''));             
			Configuration::updateValue('blockcustomerxivo_exten', (($_POST['exten'] != '') ? $_POST['exten']: ''));             
			Configuration::updateValue('blockcustomerxivo_context', (($_POST['context'] != '') ? $_POST['context']: ''));             
			$this->_clearCache('blockcustomerxivo.tpl');
			$output = '<div class="conf confirm">'.$this->l('Configuration updated').'</div>';
		}

		return '
		<h2>'.$this->displayName.'</h2>
		'.$output.'
		<form action="'.Tools::htmlentitiesutf8($_SERVER['REQUEST_URI']).'" method="post">
		    <fieldset class="width2">               
			<label for="xivo_url">'.$this->l('XiVO URL: ').'</label>
			<input type="text" id="xivo_url" name="xivo_url" value="'.Tools::safeOutput((Configuration::get('blockcustomerxivo_xivo_url') != "") ? Configuration::get('blockcustomerxivo_xivo_url') : "").'" />
			<div class="clear">&nbsp;</div>     
			<label for="login">'.$this->l('Login: ').'</label>
			<input type="text" id="login" name="login" value="'.Tools::safeOutput((Configuration::get('blockcustomerxivo_login') != "") ? Configuration::get('blockcustomerxivo_login') : "").'" />
			<div class="clear">&nbsp;</div>     
			<label for="secret">'.$this->l('Secret: ').'</label>
			<input type="text" id="secret" name="secret" value="'.Tools::safeOutput((Configuration::get('blockcustomerxivo_secret') != "") ? Configuration::get('blockcustomerxivo_secret') : "").'" />
			<div class="clear">&nbsp;</div>                     
			<label for="outcontext">'.$this->l('Out context: ').'</label>
			<input type="text" id="outcontext" name="outcontext" value="'.Tools::safeOutput((Configuration::get('blockcustomerxivo_outcontext') != "") ? Configuration::get('blockcustomerxivo_outcontext') : "").'" />
			<div class="clear">&nbsp;</div>                     
			<label for="exten">'.$this->l('Internal extension: ').'</label>
			<input type="text" id="exten" name="exten" value="'.Tools::safeOutput((Configuration::get('blockcustomerxivo_exten') != "") ? Configuration::get('blockcustomerxivo_exten') : "").'" />
			<div class="clear">&nbsp;</div>                     
			<label for="context">'.$this->l('Internal context: ').'</label>
			<input type="text" id="context" name="context" value="'.Tools::safeOutput((Configuration::get('blockcustomerxivo_context') != "") ? Configuration::get('blockcustomerxivo_context') : "").'" />
			<div class="clear">&nbsp;</div>                     
			<br /><center><input type="submit" name="submitModule" value="'.$this->l('Update settings').'" class="button" /></center>
		    </fieldset>
		</form>';
	}
	
	public function hookdisplayLeftColumnProduct($params)
	{
		global $smarty, $cookie, $link;		
		
		$product = new Product((int)Tools::getValue('id_product'), false, $this->context->language->id);
		$image = Product::getCover((int)$product->id);

		if (isset($product) && $product != '')
		{		
			$product_infos = $this->context->controller->getProduct();
			$smarty->assign(array(
					'xivo_url' => Configuration::get('blockcustomerxivo_xivo_url'),
					'product' => $product,
					'product_cover' => (int)$product->id.'-'.(int)$image['id_image'],
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

	public function doCall()
	{

		$number = Tools::getValue('phone_number');

		$url = Configuration::get('blockcustomerxivo_xivo_url');
		$login = Configuration::get('blockcustomerxivo_login');
		$secret = Configuration::get('blockcustomerxivo_secret');
		$outcontext = Configuration::get('blockcustomerxivo_outcontext');
		$exten = Configuration::get('blockcustomerxivo_exten');
		$context = Configuration::get('blockcustomerxivo_context');
		$priority = 1;

		$config = array ( "urlraw" => $url . "/rawman",
				  "admin" => $login,
				  "secret" => $secret,
				  "authtype" => "plaintext",
				  "cookiefile" => "/tmp/ajam.cookies",
				  "debug" => null
				);

		$connect = new Ajam($config);

		$params = array ( "Channel" => "Local/". $number ."@" . $outcontext,
				  "Exten" => $exten,
				  "Context" => $context,
				  "Priority" => $priority,
				  "CallerId" => $number,
				  "Async" => 1,
				  "Variable" => "__product_id=" . Tools::getValue('product_id') . 
						",__product_link=" . Tools::getValue('product_link') . 
						",__product_title=" . Tools::getValue('product_title')
				);

		$connect->doCommand("Originate", $params);
	}
}

?>
