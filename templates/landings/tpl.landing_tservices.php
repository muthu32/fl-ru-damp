<?php if ($use_ajax): ?>
    <?php $xajax->printJavascript('/xajax/'); ?>
<?php endif; ?>

<?php if (isset($profs) && $profs): ?>
<div class="b-layout b-layout_margbot_30 b-layout__landing_bg_gray">
    <h2 class="b-page__title b-page__title_center b-page__title_relative">
        <div class="b-menu__banner_landing">
            <?php require_once($_SERVER['DOCUMENT_ROOT'] . "/banner_promo.php"); ?>
        </div>
        <a href="/freelancers/" class="b-page__title_decor_none b-page__title_color_32">������� �����������</a>
    </h2>
    <div class="b-layout b-layout_col_5 b-layout_col_3_ipad b-layout_col_2_iphone b-layout_marglr_30_iphone b-layout_col_1_r560">
    <?php foreach ($profs as $prof): ?>
        <?php if (!isset($groups_repeat[$prof['grouplink']]) && ($groups_repeat[$prof['grouplink']] = 1)): ?>
                <div class="b-layout__txt b-layout__txt_inline-block b-layout__txt_padbot_10"><a class="b-layout__link b-layout__link_no-decorat b-layout__link_fontsize_13" href="/freelancers/<?=$prof['grouplink']?>"><?=$prof['groupname']?></a></div><br>
        <?php endif; ?>
    <?php endforeach; ?>
                <div class="b-layout__txt b-layout__txt_inline-block"><span class="b-layout__txt b-layout__txt_float_left b-layout__txt_padtop_3"><?php require_once($_SERVER['DOCUMENT_ROOT'] . "/banner_promo.php"); ?></span></div>
    </div>
</div>
<?php endif; ?>
    
<?php if ($tservices): ?>
    <h2 class="b-page__title b-page__title_center">
        <a href="/tu/" class="b-page__title_decor_none b-page__title_color_32">���������� ������</a>
    </h2>
    <?php if (isset($tServiceBindTeaserShort)): ?>
        <?php $tServiceBindTeaserShort->run(); ?>
    <?php endif; ?>
    <div class="b-layout b-layout_box">
        <?php if (isset($tserviceBindTeaser)): ?>
            <?php $tserviceBindTeaser->run(); ?>
        <?php endif; ?>
        
        <?php foreach ($tservices as $k => $tservice): ?>
            <?php
            $user = $tservice['user'];
            $user_url = sprintf('/users/%s', $user['login']);
            $tservice_url = sprintf('/tu/%d/%s.html', $tservice['id'], tservices_helper::translit($tservice['title']));
            $avatar_url = tservices_helper::photo_src($user['photo'], $user['login']);

            //$hasVideo = !empty($tservice['videos']) && count($tservice['videos']);
                    $hasVideo = false; //������ ������ �����-����� - ������
            if ($hasVideo)
            {
                $video = current($tservice['videos']);
                $video_thumbnail_url = tservices_helper::setProtocol($video['image']);
                $thumbnail200x150 = '<img width="200" height="150" class="b-pic" src="'.$video_thumbnail_url.'">';
            } elseif(!empty($tservice['file']))
            {
                $hasVideo = false;
                $image_url = tservices_helper::image_src($tservice['file'],$user['login']);
                $thumbnail200x150 = '<img width="200" height="150" class="b-pic" src="'.$image_url.'">';
            } else
            {
                $thumbnail200x150 = '<div class="b-pic b-pic_no_img b-pic_w200_h150 b-pic_bg_f2"></div>';
            }

            $hasVideo = !empty($tservice['videos']) && count($tservice['videos']);

            $sold_count = isset($tservice['count_sold']) ? $tservice['count_sold'] : $tservice['total_feedbacks']; // ���� ������ �� ������� ��� �������, ����� ����� ������. #0026584
            
            $hide_block = isset($tserviceBindTeaser) && ($k+1) == count($tservices);
            ?>  
        
            <?php if (isset($tservice['is_binded']) && $tservice['is_binded']): ?>
            <div class="b-layout__tu-cols b-layout__tu-cols_height_330 <?php if($hide_block): ?><?=' b-layout_hide'?><?php endif;?>">
                <div class="b-pay-tu b-pay-tu_payed<?=($tservice['user_id']==$uid) ? '-my' : ''?>">
                    <span class="b-pay-tu__mpin"></span>
                    <div class="b-pay-tu__inner">
                        <figure class="i-pic i-pic_port i-pic_port_z-index_inherit i-pic_pad_10 i-pic_height_265 ">
            <?php else: ?>
                 <div class="b-layout__tu-cols b-layout__tu-cols_height_330 <?php if($hide_block): ?><?=' b-layout_hide'?><?php endif;?>">
                    <figure class="i-pic i-pic_port i-pic_port_z-index_inherit i-pic_pad_10 i-pic_height_265 i-pic_bord_green_hover">           
            <?php endif; ?>
            
                        <div class="b-layout b-layout_relative">
                            <a class="b-pic__lnk b-pic__lnk_relative" href="<?=$tservice_url?>">
                                <?php if ($hasVideo) { ?><div class="b-icon b-icon__play b-icon_absolute b-icon_bot_4 b-icon_left_4"></div><?php } ?>
                                <?=$thumbnail200x150?>
                            </a>
                            <a onclick="TServices_Catalog.orderNow(this);" data-url="<?=$tservice_url?>" href="javascript:void(0);" class="b-pic__price-box b-pic__price-box_pay b-pic__price-box b-pic__price-box_noline">
                                <?=tservices_helper::cost_format($tservice['price'],true)?>
                                <?php if ($sold_count != 0): ?>        
                                    <span title="���������� ������ ������"><span class="b-icon b-icon__tu2 b-icon_top_2"></span><?=number_format($sold_count, 0, '', ' ')?></span>
                                <?php endif; ?>
                            </a>
                        </div>
                        <figcaption class="b-layout__txt b-layout__txt_padtop_10 b-layout_overflow_hidden">
                            <a class="b-layout__link b-layout__link_no-decorat b-layout__link_color_000 b-layout__link_inline-block" href="<?=$tservice_url?>"><?=LenghtFormatEx(reformat($tservice['title'], 20, 0, 1),80)?></a>
                        </figcaption>
                        <div class="b-user b-user_padtop_10">
                            <?php $fullname = view_fullname($user, true); ?>
                            <a class="b-user__link b-user__link_color_ec6706" title="<?=$fullname?>" href="<?=$user_url?>">
                                <img width="15" height="15" class="b-user__pic b-user__pic_15" src="<?=$avatar_url?>" alt="<?=$fullname?>">
                                <?=$fullname?></a>
                            <span class="b-user_nowrap">
                                <a title="<?=$fullname?>" href="<?=$user_url?>/tu/" class="b-user__link b-user__link_color_ec6706">[<?=$user['login']?>]</a><?=view_user_label($user)?>
                            </span>
                        </div>
                    
            <?php if (isset($tservice['is_binded']) && $tservice['is_binded']): ?>
                        </figure>
                        <?php if ($tservice['user_id']==$uid): ?> 
                     <?php //@todo �������� div ���� �� $tserviceBindLinks->run(); ?>
                        <div class="b-pay-tu__hider b-layout_padleft_20">
                            <div class="b-layout__txt b-layout__txt_bold b-layout__txt_padbot_10 b-layout__txt_fontsize_15">
                                ������ ����������<br>�� <?=dateFormat('j', $tservice['date_stop']).' '.monthtostr(dateFormat('m', $tservice['date_stop']), true) ?>
                            </div>
                            <div class="b-layout__txt b-layout__txt_bold b-layout__txt_color_6db335 b-layout__txt_padbot_5 b-layout__txt_fontsize_15">
                                �������� �����������<br>�� 7 � ����� ����
                            </div>
                            <a class="b-button b-button_flat b-button_flat_green" href="#" 
                               data-popup="<?=quickPaymentPopupTservicebind::getInstance()->getPopupId($tservice['id']) ?>">
                                ��������
                            </a>
                            <?php if ($k > 0):?>
                                <div class="b-layout__txt b-layout__txt_bold b-layout__txt_color_6db335 b-layout__txt_padbot_5 b-layout__txt_fontsize_15 b-layout__txt_padtop_20">
                                    ��������� ������ ��<br>1 ����� �� <?=view_cost_format($bindUpPrice,false)?> ������
                                </div>
                                <a class="b-button b-button_flat b-button_flat_green" href="#"
                                   data-popup="<?=quickPaymentPopupTservicebindup::getInstance()->getPopupId($tservice['id']) ?>">
                                    �������
                                </a>
                            <?php endif; ?>
                        </div>
                     
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php else: ?>
                    </figure>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
        
        <?php foreach ($popups as $popup): ?>
            <?=$popup?>
        <?php endforeach; ?>
    </div>

    <div class="b-layout b-layout_padbot_30 b-layout_top_-30">
        <div class="b-pager">
            <ul class="b-pager__list">
                <li class="b-pager__item">
                    <a class="b-pager__link" href="/tu/">��� ������</a>
                </li>
            </ul>
        </div>
    </div>
<?php endif; ?>

<?php
    
    include ($_SERVER['DOCUMENT_ROOT'] . "/templates/landings/tpl.landing_profi.php");

?>    
    
<?php if(!get_uid(false)){ ?>
<div class="b-layout b-layout_clear_both b-layout_bordtop_b2 b-layout_padtop_20 b-layout_top_100">
    <h2 class="b-page__title b-page__title_center">Fl.ru &mdash; ���������� ������������� ����� ��������� ������ </h2>
    <table class="b-layout__table b-layout__table_width_full b-layout__table_margbot_20">
        <tr class="b-layout__tr">
            <td class="b-layout__td b-layout__td_width_50ps b-layout__td_padright_70">
                <h3 class="b-layout__title b-layout__title_center b-layout__title_padbot_20">��� ���, ���� ����� ���������� (���������)</h3>
                <p class="b-layout__txt b-layout__txt_padbot_5">
                    � ��� �� ������ ����� ������ ������� ������������ ����� 1 ��� ������������, ������������������ �� ����� FL.ru. ������������, ���������, ���������, �����������, ������, ����������, ��������, ��������� - ������ ��������� ����������� �� ����� freelance ��������������.
                </p>
                <p class="b-layout__txt b-layout__txt_padbot_5">
                    ��� ���������� ������������ ������, ������� ��� �������� - � ���������������� ���������� ���� ��������� ���� ������, ������� ��� ������������ �������, ���������� ������ � ����� ���������� ������. ��������� ������ ������� ������� ����������� �� ����� �������������� ������� ������������ � ������ � ��� ��������������.
                </p>
                <p class="b-layout__txt b-layout__txt_padbot_5">
                    ���� �� ������ ��� ������� �� �������, �� ������ ������ ����� � �������� ������ ������ (� ������������� ����� � ������ ����������) � ����� �������� �����. � ����� ������� ��������� ������������ � ��������, ������ �� ��������� � ��������������� �������� - � � 2 ����� ���������� �����.
                </p>
                <p class="b-layout__txt b-layout__txt_padbot_5">
                    FL.ru �� ������������ freelance ��������������! ����������� ��� ������ "���������� ������" � ��������������� ����� �� ����� ��� �������������� � ������������ - � �� ����������� ��� ������� �������, ���� ������ ����� ��������� ������������� �/��� �� � ����.
                </p>
                <p class="b-layout__txt b-layout__txt_padbot_30">������� ��� ������������!</p>      
            </td>

            <td class="b-layout__td b-layout__td_padleft_50">
                <h3 class="b-layout__title b-layout__title_center b-layout__title_padbot_20">���, ��� ���� ������ �� ���� (�����������)</h3>
                <p class="b-layout__txt b-layout__txt_padbot_5">
                    ��� ��� ��������� ����� 1500 ������� ��������, ��������� � �������� � ������� ������������. ���� �� ����� ��������� ������ ����������� � ������ ��������� �����, ������ ������, ����������������, ���������������, ��������� freelance ������ �� ���� - ����� ���������� �� ���� FL.ru.
                </p>
                <p class="b-layout__txt b-layout__txt_padbot_5">
                    ������� ������ � ����� ������, ��� ������ ����� ���������� ��������� ��������� ����������, ������� ������� ������� ����������� ���� �������� � �������. ������� � ������� ��� ����������� ���������� � ����� ������� � �����, �������� ���������� ������.
                </p>
                <p class="b-layout__txt b-layout__txt_padbot_5">
                    ����������� ��� ��������� ������ ����������� ��������� ������������� ����� ��������, ������� �� ���������� ��� ����������� - � ������ ������������������ ��������� ����������� ��������� ��� �������������� �� freelance �������� � ���������� ����������� ������.
                </p>
                <p class="b-layout__txt b-layout__txt_padbot_5">
                    ����� �������� ����� �������� ������, ����� ����������� ���������� �������� � �������� �� ���� ��� ���� ������, ������ �� � ������ ��������� � ���� ���������� ���� ��� ����� ������ �����. � �� �������� ���������� ������� PRO - ������, ������� ����������� �������� ����������� ������ ������� ������� � ������� �������� ��� ������ �������� �������.
                </p>
                <p class="b-layout__txt b-layout__txt_padbot_30">��������� ������ ������!</p>
            </td>
        </tr>
        <tr class="b-layout__tr">
            <td class="b-layout__td b-layout__td_padbot_40 b-layout__td_width_50ps b-layout__td_padright_70">
                <div class="b-buttons b-buttons_center"><a class="b-button b-button_flat b-button_flat_green"  href="/public/?step=1&kind=1&red=">������������ ������ � ����� �����������</a></div>
            </td>
            <td class="b-layout__td b-layout__td_padbot_40 b-layout__td_padleft_50">
                <div class="b-buttons b-buttons_center "><a class="b-button b-button_flat b-button_flat_green"  href="/registration/">����� ����������� � ����� ������</a></div>
            </td>
    </table>
</div>
<?php } ?>
