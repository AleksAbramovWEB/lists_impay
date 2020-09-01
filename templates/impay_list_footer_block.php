<?php
	/**
	 * @var ImpayLists $list
	 */
?>
<div class="impay_lists_footer">
	<div class="count_string_list">
		<?php if ($list->getCount() == 0):?>
			Записи не найдены
		<?php elseif(($list->getCount() - $list->getUntil()) < 10):?>
			Записи с <?=$list->getFrom()?> до <?=$list->getCount()?> из <?=$list->getCount()?> записей
		<?php else:?>
			Записи с <?=$list->getFrom()?> до <?=$list->getUntil()?> из <?=$list->getCount()?> записей
		<?php endif;?>
	</div>
	<div>
		<a <?=($list->getFrom() == 0)?'class="disabled"':''?>
			data-from="<?=$list->getFrom()?>"
			id="impay_paginate_button_previous"><span class="dashicons dashicons-arrow-left-alt2"></span>Предыдущая</a>
		<a <?=($list->getCount() <= $list->getUntil())?'class="disabled"':''?>
			data-until="<?=$list->getUntil()?>"
			id="impay_paginate_button_next">Следующая<span class="dashicons dashicons-arrow-right-alt2"></span></a>
	</div>
</div>
