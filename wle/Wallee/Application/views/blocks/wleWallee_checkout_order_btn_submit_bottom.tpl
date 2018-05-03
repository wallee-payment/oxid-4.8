[{if ($oView->isWalleeTransaction()) }]
<button type="submit" id="button-confirm" class="btn btn-lg btn-primary pull-right submitButton nextStep largeButton" disabled="disabled">
	<i class="fa fa-check"></i> [{oxmultilang ident="SUBMIT_ORDER"}]
</button>
[{else}]
[{$smarty.block.parent}]
[{/if}]