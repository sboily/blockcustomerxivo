{*
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
*}


<li id="blockcustomerxivo">
	<a id="call_button" href="#call_form">{l s='Call us for more informations' mod='blockcustomerxivo'}</a>
</li>

<div style="display: none;">
    <div id="call_form">
            <h2 class="title">{l s='Call us for support' mod='blockcustomerxivo'}</h2>
            <div class="product clearfix">
                <img src="{$link->getImageLink($product->link_rewrite, $product_cover, 'home_default')|escape:'html'}" 
                     height="{$homeSize.height}" width="{$homeSize.width}" alt="{$product->name|escape:html:'UTF-8'}" />
                <div class="product_desc">
                    <p class="product_name"><strong>{$product->name}</strong></p>
                    {$product->description_short}
                </div>
            </div>

            <div class="call_form_content" id="call_form_content">
                <div id="call_form_error"></div>
                <div id="call_form_success"></div>
                <div class="form_container">
                    <p class="intro_form">{l s='Please give us your number' mod='blockcustomerxivo'} :</p>
                    <p class="text">
                        <label for="phone_number">{l s='Phone number' mod='blockcustomerxivo'} <sup class="required">*</sup> : </label>
                        <input id="phone_number" name="phone_number" type="text" value=""/>
                    </p>
                    <p class="txt_required"><sup class="required">*</sup> {l s='Required fields' mod='blockcustomerxivo'}</p>
                </div>
                <p class="submit">
                    <input id="product_link" name="product_link" type="hidden" value="{$product_link}" />
                    <input id="product_title" name="product_title" type="hidden" value="{$product_title}" />
                    <input id="product_id" name="product_id" type="hidden" value="{$product->id}" />
                    <input id="module_dir" name="module_dir" type="hidden" value="{$module_dir}" />
                    <a href="#" onclick="$.fancybox.close();">{l s='Cancel' mod='blockcustomerxivo'}</a>&nbsp;{l s='or' mod='blockcustomerxivo'}&nbsp;
                    <input id="sendCall" class="button" name="sendCall" type="submit" value="{l s='Call' mod='blockcustomerxivo'}" />
                </p>
            </div>
    </div>
</div>

