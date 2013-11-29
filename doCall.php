<?php

/*
* * 2013 Avencall
* *
* * NOTICE OF LICENSE
* *
* * This source file is subject to the Academic Free License (AFL 3.0)
* * that is bundled with this package in the file LICENSE.txt.
* * It is also available through the world-wide-web at this URL:
* * http://opensource.org/licenses/afl-3.0.php
* * If you did not receive a copy of the license and are unable to
* * obtain it through the world-wide-web, please send an email
* * to contact@avencall.com so we can send you a copy immediately.
* *
* * DISCLAIMER
* *
* * Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* * versions in the future. If you wish to customize PrestaShop for your
* * needs please refer to http://www.prestashop.com for more information.
* *
* *  @author Sylvain Boily <sboily@avencall.com>
* *  @copyright  2013 Avencall
* *  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
* *  International Registered Trademark & Property of PrestaShop SA
* */

require_once(dirname(__FILE__).'/../../config/config.inc.php');
require_once(dirname(__FILE__).'/../../init.php');
include_once(dirname(__FILE__).'/blockcustomerxivo.php');
include_once(dirname(__FILE__).'/../../classes/Product.php');

$module = new blockcustomerxivo();
$module->doCall();

die('1');

?>
