[{$smarty.block.parent}]
[{if ($oView->isWalleeTransaction()) }]
<div class="panel panel-default" id="Wallee-payment-information">
	<div class="panel-heading">
		<h3 class="panel-title section">[{oxmultilang ident="PAYMENT_INFORMATION"}]</h3>
	</div>
	<div class="panel-body">
		<div id="Wallee-iframe-spinner" class="wallee-loader"></div>
		<div id="Wallee-iframe-container" style="display:none"></div>
		<input type="hidden" name="Wallee-iframe-loaded" value="false">
	</div>
</div>
[{capture name=WalleeInitScript assign=WalleeInitScript}]
function initWalleeIframe(){
	if(typeof Wallee === 'undefined') {
    	setTimeout(initWalleeIframe, 500);
	} else {
    	Wallee.init('[{$oView->getWalleePaymentId()}]');
	}
}
jQuery().ready(initWalleeIframe);
[{/capture}]
[{oxscript add=$WalleeInitScript priority=10}]
[{oxscript include=$oView->getWalleeJavascriptUrl() priority=8}]
[{oxscript include=$oViewConf->getModuleUrl("wleWallee", "out/src/js/wallee.js") priority=9}]
[{oxstyle include=$oViewConf->getModuleUrl("wleWallee", "out/src/css/spinner.css")}]
[{/if}]