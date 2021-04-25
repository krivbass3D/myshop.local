	{* левый столбец *}

<div id="leftColumn">


<div id="leftMenu">
	<div class="menuCaption">Меню:</div>

	{foreach $rsCategories as $item}
		<a href="/?controller=category&id={$item['id']}">{$item['name']}</a><br />

		{if isset($item['children'])}
			{foreach $item['children'] as $itemChildren}
				--<a href="/?controller=category&id={$itemChildren['id']}">{$itemChildren['name']}</a><br>
			{/foreach}
		{/if}
	{/foreach}

</div>  

</div>