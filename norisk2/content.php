<?
require_once($_SERVER['DOCUMENT_ROOT'] . "/xajax/sbr.common.php");
$xajax->printJavascript('/xajax/');
?>
<a name="page"></a>
<h2>������� �� &laquo;���������� ������&raquo;</h2>
<div class="norisk">
<?
include($fpath.'header.php');
?>
<a name="body"></a>
<!--
<div class="tabs">
    <ul class="clear">
        <li class="tab1 <?=($site != 'completed' && $site != 'drafts' && $site != 'calc' ? ' active' : '')?>"><span><a href=".">������� ���</a></span></li>
        <li class="tab2 <?= $site == 'calc' ? 'active' : '' ?>"><span><a href="?site=calc" >����������� ���</a></span></li>
        <? if($sbr->isEmp()) { ?>
            <?/* <li class="tab2 <?=($site == 'old' ? ' active' : '')?>"><span><a href="/norisk/">������ ���</a></span></li> */?>
            <? if($sbr->draftExists()) { ?>
              <li class="tab3 <?=($site == 'drafts' ? ' active' : '')?>"><span><a href="?site=drafts" class="lnk-drafts">���������</a></span></li>
            <? } ?>
        <? } ?>
    </ul>
</div>
-->
<div class="b-menu b-menu_tabs b-menu_bg_f3f2f0 b-menu_relative">
    <ul class="b-menu__list b-menu__list_padleft_15">
        <li class="b-menu__item <?=($site != 'completed' && $site != 'drafts' && $site != 'calc' ? 'b-menu__item_active' : '')?>">
						<?php if (!($site != 'completed' && $site != 'drafts' && $site != 'calc')) { ?>
							<a class="b-menu__link" href="." title="������� ����������� ������">
						<?php } else print '<span class="b-menu__b2">'?>
								<span class="b-menu__b1">������� ����������� ������</span>
						<?php if (!($site != 'completed' && $site != 'drafts' && $site != 'calc')) { ?>
							</a>
						<?php } else print '</span>' ?>
				</li>
        <? if($sbr->isEmp()) { ?>
            <? if($sbr->draftExists()) { ?>
        		<li class="b-menu__item <?= $site == 'drafts' ? 'b-menu__item_active' : '' ?>"><a class="b-menu__link" href="?site=drafts" title="���������"><span class="b-menu__b1">���������</span></a></li>
            <? } ?>
        <? } ?>
        <li class="b-menu__item b-menu__item_last <?= $site == 'calc' ? 'b-menu__item_active' : '' ?>">
						<?php if ( $site != 'calc') { ?>
						<a class="b-menu__link" href="/bezopasnaya-sdelka/?site=calc" title="����������� ����������� ������">
						<?php } else print '<span class="b-menu__b2">'?>
								<span class="b-menu__b1">����������� ����������� ������</span>
						<?php if ( $site != 'calc') { ?>
						</a>
						<?php } else print '</span>' ?>
				</li>
    </ul>
</div>



<?
include($inner);
?>
</div>
