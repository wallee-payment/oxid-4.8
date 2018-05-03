[{include file="headitem.tpl" title="GENERAL_ADMIN_TITLE"|oxmultilangassign}]
<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>
[{oxscript include=$oViewConf->getModuleUrl('wleWallee','out/src/js/refund.js')}]

<form name="transfer" id="transfer" action="[{ $oViewConf->getSelfLink() }]" method="post">
    [{ $oViewConf->getHiddenSid() }]
    <input type="hidden" name="cur" value="[{ $oCurr->id }]">
    <input type="hidden" name="oxid" value="[{ $oxid }]">
    <input type="hidden" name="cl" value="order_main">
</form>

<table cellspacing="0" cellpadding="0" border="0" width="98%">
    <tr>
        <td valign="top" align="left" width="50%" style="padding: 10px;">
            <h3>[{oxmultilang ident='Refund' noerror=true}]</h3>
            <form action="[{ $oViewConf->getSelfLink() }]" method="POST"
                  class="Wallee-line-item-grid " id="completion-form">
                <input type="hidden" name="cl" value="wle_wallee_refundjob">
                <input type="hidden" name="fnc" value="refund">
                <input type="hidden" name="cur" value="[{ $oCurr->id }]">
                <input type="hidden" name="oxid" value="[{ $oxid }]">
                <table cellspacing="0" class="data" style="width:100%; margin-bottom: 20px;">
                    <thead>
                    <tr class="headings">
                        <td class="listheader first">[{oxmultilang ident='Name' noerror=true}]</td>
                        <td class="listheader">[{oxmultilang ident='SKU' noerror=true}]</td>
                        <td class="listheader">[{oxmultilang ident='Quantity' noerror=true}]</td>
                        <td class="listheader">[{oxmultilang ident='Reduction' noerror=true}]</td>
                        <td class="listheader">[{oxmultilang ident='Refund amount' noerror=true}]</td>
                    </tr>
                    </thead>
                    <tbody>
                        [{foreach from=$lineItems key=index item=lineItem}]
                            <tr class="border">
                                <td class="listitem" valign="top">[{$lineItem.name}]</td>
                                <td class="listitem" valign="top">
                                    <input type="hidden" name="item[[{$index}]][id]" value="[{$lineItem.id}]">
                                    <span>[{$lineItem.sku}]</span>
                                </td>
                                <td class="listitem" valign="top">
                                    <input type="number" name="item[[{$index}]][quantity]" max="[{$lineItem.quantity}]"
                                           min="0">
                                    <span>/ [{$lineItem.quantity}]</span>
                                </td>
                                <td class="listitem" valign="top">
                                    <input type="number" name="item[[{$index}]][price]" max="[{$lineItem.unit_price}]" min="0"
                                           value="0">
                                    <span>/ [{$lineItem.unit_price}]</span>
                                </td>
                                <td class="listitem" valign="top">
                                    <input type="text" readonly name="item[[{$index}]][total]" max="[{$lineItem.total}]"
                                           min="0">
                                </td>
                            </tr>
                        [{/foreach}]
                        <tr class="border">
                            <td colspan="4" align="right">
                                <span id="line-item-total-label">[{oxmultilang ident='Restock' noerror=true}]</span>
                            </td>
                            <td colspan="1" class="listitem" align="right">
                                <input type="checkbox" name="restock">
                            </td>
                        </tr>
                        <tr class="border">
                            <td colspan="4" align="right">
                                <span id="line-item-total-label">[{oxmultilang ident='Total' noerror=true}]</span>
                            </td>
                            <td colspan="1" class="listitem" align="right">
                                <span id="line-item-total">0.00</span>
                            </td>
                        </tr>
                        <tr class="border">
                            <td colspan="2" align="right">
                            </td>
                            <td align="right">
                                <input type="reset" value="[{oxmultilang ident='Reset' noerror=true}]">
                            </td>
                            <td align="right">
                                <input type="button" id="full-refund" value="[{oxmultilang ident='Full' noerror=true}]">
                            </td>
                            <td align="right">
                                <input type="submit" value="[{oxmultilang ident='Refund' noerror=true}]">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
        </td>
    </tr>
</table>

<script type="text/javascript">
    function WalleeInit() {
        if (typeof Refund === 'undefined') {
            setTimeout(WalleeInit, 150);
        } else {
            Refund.init('[{oxmultilang ident='Empty refund not permitted.' noerror=true}]');
        }
    }
    WalleeInit();
</script>

[{include file="bottomnaviitem.tpl"}]
[{include file="bottomitem.tpl"}]