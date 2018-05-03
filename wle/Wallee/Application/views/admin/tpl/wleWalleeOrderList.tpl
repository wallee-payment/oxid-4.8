[{include file="order_list.tpl"}]

<script
        src="https://code.jquery.com/jquery-3.3.1.min.js"
        integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
        crossorigin="anonymous"></script>

<script type="text/javascript">
$('a[href="#wle_wallee_transaction"]').parents('td').hide();
[{if $wleEnabled}]
	$('a[href="#wle_wallee_transaction"]').parents('td').show();
[{/if}]
$('td.tab').removeClass('last');
$('td.tab:visible:last').addClass('last');
</script>