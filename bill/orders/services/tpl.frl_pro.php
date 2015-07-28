<?php
$type = $pro_type[$service['op_code']];
?>
<div class="b-layout b-layout_pad_10 b-layout_bord_e6 b-layout_relative b-layout_margbot_10 service" data-name="pro_<?= $service['id']?>" data-cost="<?= round($service['ammount'])?>">
    <a href="javascript:void(0)" class="b-button b-button_admin_del b-button_float_right service-remove"></a>
    <input type="hidden" name="opcode" value="<?= $service['op_code']; ?>" />
    <span class="b-page__desktop b-page__ipad"><span class="b-icon b-icon__spro b-icon__spro_f b-icon_absolute b-icon_left_10" title="PRO"></span></span>
    <h3 class="b-layout__h3 b-layout__h3_padleft_70">���������������� �������  �� 
        <span class="i-shadow">
            <a class="b-layout__link b-layout__link_inline-block b-layout__link_bold b-layout__link_fontsize_15 b-layout__link_ygol popup-top-mini-open upd-auto-period-data" href="javascript:void(0)"><?= $type['month']?> <? if($type['day']) { ?><?= ending($type['day'], '����', '���', '����')?><? } elseif($type['week']) { ?><?= ending($type['week'], '������', '������', '������')?><? } else { ?><?= ending($type['month'], '�����', '������', '�������')?><? } ?></a>
            <div class="b-shadow b-shadow_m b-shadow_left_-11 b-shadow_top_25 b-shadow_hide b-shadow_width_335 popup-mini body-shadow-close change-select-period">
                <div class="b-shadow__right">
                    <div class="b-shadow__left">
                        <div class="b-shadow__top">
                            <div class="b-shadow__bottom">
                                <div class="b-shadow__body b-shadow__body_bg_fff b-shadow__body_pad_10">
                                <?php foreach($pro_type as $opcode => $data) { $eco   = ( $data['month'] * payed::PRICE_FRL_PRO - $data['cost'] ); ?>
                                <div class="b-layout__txt b-layouyt__txt_weight_normal">
                                    <a class="b-layout__link b-layout__link_no-decorat select-auto-type" href="javascript:void(0)"
                                       data-opcode="<?= $data['opcode']?>"
                                       data-cost="<?= $data['cost']?>" 
                                       data-period="<?= $data['month']?> <? if($data['day']) { ?><?= ending($data['day'], '����', '���', '����')?><? } elseif($data['week']) { ?><?= ending($data['week'], '������', '������', '������')?><? } else { ?><?= ending($data['month'], '�����', '������', '�������')?><? } ?>">
                                        <span class="b-layout__txt b-layout__txt_inline-block b-layout__txt_width_90 <?= $opcode == $service['op_code'] ? "b-layout__txt_color_808080" : ""?> b-layout__txt_fontsize_15 select-name">
                                            <? if($data['day']) { ?>
                                                <?= $data['day']?> <?= ending($data['day'], '����', '���', '���')?>
                                            <? } elseif ($data['week']) { ?>
                                                <?= $data['week']?> <?= ending($data['week'], '������', '������', '������')?>
                                            <? } else { ?>
                                                <?= $data['month']?> <?= ending($data['month'], '�����', '������', '�������')?>
                                            <? } ?>
                                        </span>
                                        <span class="b-layout__txt b-layout__txt_inline-block b-layout__txt_width_90 b-layout__txt_fontsize_15 b-layout__txt_color_fd6c30 b-layout__txt_nowrap"><?= to_money($data['cost'])?> ������</span>
                                    </a>
                                </div>
                                <?php 
                                }//foreach?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <span class="b-shadow__icon b-shadow__icon_nosik b-shadow__icon_left_30"></span>
            </div>
        </span>                     
        &nbsp;&nbsp;&nbsp;&nbsp; <span class="b-layout__txt b-layout__txt_fontsize_11 b-layouyt__txt_weight_normal"><a href="/payed/" class="b-layout__link">��������� �� ������</a></span>
    </h3>
    <div class="b-layout__txt b-layout__txt_fontsize_11 b-layout__txt_padbot_20 b-layout__txt_padleft_70">������� PRO ������������� ����� ����������� ������ �� �����: �������� ��������, ����������� ������ �� �������, ����������� �������, �������������� ������������� � �������� �����������, ����������� ����������� � ��������� � ������ ������.</div>
    <span class="walletInfo">
    <?php
//    if($bill->wallet != false) {
//        $wallet = $bill->wallet;
//        include($_SERVER['DOCUMENT_ROOT'] . "/bill/widget/tpl.info_wallet.php");
//    }
    ?>
    </span>

    <div class="b-layout__txt b-layout__txt_padleft_70 b-layout__txt_fontsize_22 b-layout__txt_color_fd6c30"><span class="upd-cost-sum"><?= to_money($type['cost']) ?></span> ���.</div>
</div>