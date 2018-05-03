[{$smarty.block.parent}]
[{foreach from=$oView->getWleAlerts() item=alert}]
    <li class="sep">
        <a href="[{$oViewConf->getSelfLink()}]&cl=wle_wallee_Alert&amp;fnc=[{$alert.func}]" target="[{$alert.target}]" class="rc"><b>[{$alert.title}]</b></a>
    </li>
[{/foreach}]