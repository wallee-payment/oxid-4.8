[{if count($oOrders) > 0}]
[{assign var=oArticleList value=$oView->getOrderArticleList()}]
<ol class="list-unstyled">
	[{foreach from=$oOrders item=order}]
	<li>
		<hr style="background-color: #ECEFF0; height: 5px; margin: 10px 0; border: none;"><div style="background-color: white" class="clear lineBox">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<strong>[{oxmultilang ident="ORDER_DATE"}]</strong>
						<span id="accOrderDate_[{$order->oxorder__oxordernr->value}]">[{$order->oxorder__oxorderdate->value|date_format:"%d.%m.%Y"}]</span>
						<span>[{$order->oxorder__oxorderdate->value|date_format:"%H:%M:%S"}]</span>
					</div>
					<div class="col-xs-3">
						<strong>[{oxmultilang ident="STATUS"}]</strong>
						<span id="accOrderStatus_[{$order->oxorder__oxordernr->value}]">
										[{if $order->oxorder__oxstorno->value}]
											<span class="note">[{oxmultilang ident="ORDER_IS_CANCELED"}]</span>
										[{elseif $order->oxorder__oxsenddate->value !="-"}]
											<span>[{oxmultilang ident="SHIPPED"}]</span>
										[{else}]
											<span class="note">[{oxmultilang ident="NOT_SHIPPED_YET"}]</span>
										[{/if}]
									</span>
					</div>
					<div class="col-xs-3">
						<strong>[{oxmultilang ident="ORDER_NUMBER"}]</strong>
						<span id="accOrderNo_[{$order->oxorder__oxordernr->value}]">[{$order->oxorder__oxordernr->value}]</span>
					</div>
					<div class="col-xs-3">
						<strong>[{oxmultilang ident="SHIPMENT_TO"}]</strong>
						<span id="accOrderName_[{$order->oxorder__oxordernr->value}]">
										[{if $order->oxorder__oxdellname->value}]
											[{$order->oxorder__oxdelfname->value}]
											[{$order->oxorder__oxdellname->value}]
										[{else}]
											[{$order->oxorder__oxbillfname->value}]
											[{$order->oxorder__oxbilllname->value}]
										[{/if}]
									</span>
						[{if $order->getShipmentTrackingUrl()}]
						&nbsp;|&nbsp;<strong>[{oxmultilang ident="TRACKING_ID"}]</strong>
						<span id="accOrderTrack_[{$order->oxorder__oxordernr->value}]">
											<a href="[{$order->getShipmentTrackingUrl()}]">[{oxmultilang ident="TRACK_SHIPMENT"}]</a>
										</span>
						[{/if}]
					</div>
				</div>
			</div>
			<div class="panel-body">
				<strong>[{oxmultilang ident="CART"}]</strong>
				<ol class="list-unstyled">
					[{foreach from=$order->getOrderArticles(true) item=orderitem name=testOrderItem}]
					[{assign var=sArticleId value=$orderitem->oxorderarticles__oxartid->value}]
					[{assign var=oArticle value=$oArticleList[$sArticleId]}]
					<li id="accOrderAmount_[{$order->oxorder__oxordernr->value}]_[{$smarty.foreach.testOrderItem.iteration}]">
						[{$orderitem->oxorderarticles__oxamount->value}] [{oxmultilang ident="QNT"}]
						[{if $oArticle->oxarticles__oxid->value && $oArticle->isVisible()}]
						<a id="accOrderLink_[{$order->oxorder__oxordernr->value}]_[{$smarty.foreach.testOrderItem.iteration}]" href="[{$oArticle->getLink()}]">
							[{/if}]
							[{$orderitem->oxorderarticles__oxtitle->value}] [{$orderitem->oxorderarticles__oxselvariant->value}] <span class="amount"></span>
							[{if $oArticle->oxarticles__oxid->value && $oArticle->isVisible()}]
						</a>
						[{/if}]
						[{foreach key=sVar from=$orderitem->getPersParams() item=aParam}]
						[{if $aParam}]
					<br />[{oxmultilang ident="DETAILS"}]: [{$aParam}]
						[{/if}]
						[{/foreach}]
						[{* Commented due to Trusted Shops precertification. Enable if needed *}]
						[{*
										[{oxhasrights ident="TOBASKET"}]
										[{if $oArticle->isBuyable()}]
										  [{if $oArticle->oxarticles__oxid->value}]
											<a id="accOrderToBasket_[{$order->oxorder__oxordernr->value}]_[{$smarty.foreach.testOrderItem.iteration}]" href="[{oxgetseourl ident=$oViewConf->getSelfLink()|cat:"cl=account_order" params="fnc=tobasket&amp;aid=`$oArticle->oxarticles__oxid->value`&amp;am=1"}]">[{oxmultilang ident="TO_CART"}]</a>
										  [{/if}]
										[{/if}]
										[{/oxhasrights}]
										*}]
					</li>
					[{/foreach}]
				</ol>
				[{if $order->getWalleeDownloads()}]
				<strong>[{oxmultilang ident="wle_wallee_Downloads"}]</strong>
				<ul class="list-unstyled">
					[{foreach from=$order->getWalleeDownloads() item=wledownload}]
					<li><a href="[{$wledownload.link}]">[{$wledownload.text}]</a></li>
					[{/foreach}]
				</ul>
				[{/if}]
			</div>
		</div>
	</li>
	[{/foreach}]
</ol>
[{include file="widget/locator/listlocator.tpl" locator=$oView->getPageNavigation() place="bottom"}]
[{else}]
[{oxmultilang ident="ORDER_EMPTY_HISTORY"}]
[{/if}]