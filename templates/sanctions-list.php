<?php
	/**
	 * @var ImpayLists $list
	 */
?>
<div>
    <hr class="hr_impay_one">
    <?php foreach ($list->getData() as $datum):?>
        <div>
            <div class="impay_list_string_title">
                <div><?=$datum->sdn_name?></div>
                <div class="dashicons dashicons-arrow-down"></div>
            </div>
            <div class="impay_list_hidden_info">
                <div class="impay_list_grid">
                    <?php if (!is_null($datum->sdn_name)):?><div>sdn_name:</div><div><?=$datum->sdn_name?></div><?php endif;?>
                    <?php if (!is_null($datum->sdn_type)):?><div>sdn_type:</div><div><?=$datum->sdn_type?></div><?php endif;?>
                    <?php if (!is_null($datum->program)):?><div>program:</div><div><?=$datum->program?></div><?php endif;?>
                    <?php if (!is_null($datum->title)):?><div>title:</div><div><?=$datum->title?></div><?php endif;?>
                    <?php if (!is_null($datum->call_sign)):?><div>call_sign:</div><div><?=$datum->call_sign?></div><?php endif;?>
                    <?php if (!is_null($datum->vess_type)):?><div>vess_type:</div><div><?=$datum->vess_type?></div><?php endif;?>
                    <?php if (!is_null($datum->tonnage)):?><div>tonnage:</div><div><?=$datum->tonnage?></div><?php endif;?>
                    <?php if (!is_null($datum->grt)):?><div>grt:</div><div><?=$datum->grt?></div><?php endif;?>
                    <?php if (!is_null($datum->vess_flag)):?><div>vess_flag:</div><div><?=$datum->vess_flag?></div><?php endif;?>
                    <?php if (!is_null($datum->vess_owner)):?><div>vess_owner:</div><div><?=$datum->vess_owner?></div><?php endif;?>
                    <?php if (!is_null($datum->remarks)):?><div>remarks:</div><div><?=$datum->remarks?></div><?php endif;?>
                    <?php if (!is_null($datum->comment)):?><div>comment:</div><div><?=$datum->comment?></div><?php endif;?>
                </div>
                <?php if (!empty($datum->add)):?>
                    <h4>Адреса:</h4>
                    <div>
                        <?php foreach ($datum->add as $add):?>
                            <hr class="hr_impay_two">
                            <div class="impay_list_grid">
                                <?php if (!is_null($add->address)):?><div>address:</div><div><?=$add->address?></div><?php endif;?>
                                <?php if (!is_null($add->city)):?><div>city:</div><div><?=$add->city?></div><?php endif;?>
                                <?php if (!is_null($add->country)):?><div>country:</div><div><?=$add->country?></div><?php endif;?>
                                <?php if (!is_null($add->add_remarks)):?><div>remarks:</div><div><?=$add->add_remarks?></div><?php endif;?>
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php endif;?>
                <?php if (!empty($datum->alt)):?>
                    <h4>Альтернативные данные:</h4>
                    <div>
                        <?php foreach ($datum->alt as $alt):?>
                            <hr class="hr_impay_two">
                            <div class="impay_list_grid">
                                <?php if (!is_null($alt->alt_name)):?><div>alt_name:</div><div><?=$alt->alt_name?></div><?php endif;?>
                                <?php if (!is_null($alt->alt_type)):?><div>alt_type:</div><div><?=$alt->alt_type?></div><?php endif;?>
                                <?php if (!is_null($alt->alt_remarks)):?><div>alt_remarks:</div><div><?=$alt->alt_remarks?></div><?php endif;?>
                            </div>
                        <?php endforeach;?>
                    </div>
                <?php endif;?>
            </div>
        </div>
        <hr class="hr_impay_one">
    <?php endforeach;?>
</div>

<?php include __DIR__.'/impay_list_footer_block.php'?>

