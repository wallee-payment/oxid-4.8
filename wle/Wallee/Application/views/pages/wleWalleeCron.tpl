[{smarty.block.parent}]
[{assign var=cronUrl value=$oViewConf->getViewConfigParam('wleCronUrl')}]
[{if $cronUrl}]
<script type="text/javascript" async="async" src="[{$cronUrl}]"></script>
[{/if}]