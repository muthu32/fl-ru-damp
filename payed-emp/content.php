<?
if($uid) {
	require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/employer.php");
	$user = new employer();

    // �������� ���� ��������� PRO, ���� �����
    if(strtolower($_GET['pro_auto_prolong'])=='on') {
        $user->setPROAutoProlong('on',get_uid());
    }
    if(strtolower($_GET['pro_auto_prolong'])=='off') {
        $user->setPROAutoProlong('off',get_uid());
    }

	$user->GetUser($_SESSION['login']);
	require_once($_SERVER['DOCUMENT_ROOT'] . "/classes/account.php");
	$account = new account();
	$ok = $account->GetInfo($_SESSION['uid'], true);

    $u_is_pro_auto_prolong = $user->GetField($uid, $e, 'is_pro_auto_prolong', false); // �������� �� � ����� �������������� ��������� PRO
?>
<script type="text/javascript">
tr = true;
var PRICE_EMP_PRO = <?= payed::PRICE_EMP_PRO; ?>;
	function chang(t){
		var amm = <?= round($account->sum,2);?>;
		var s = t;
		var re = /^[0-9]*$/i;
		if ( s.match(re) == null) { tr = false; return (false); document.getElementById('buy').disabled = true;}
		v = t * PRICE_EMP_PRO;

		if (v > amm) { document.getElementById('error').className = 'error vis'; document.getElementById('buy').disabled = true;
			}else{
				document.getElementById('buy').disabled = false;document.getElementById('error').className = 'error';
			}
		document.getElementById('it').innerHTML='����� � ������: <span>' + v + '</span> ������';
	
		return (true);
	}

</script>
<?php } ?>

<script type="text/javascript">
var alowLogin = function(){
    if($('login_inp').get('value') != '' && $('pass_inp').get('value') != ''){
        $('auth_form').submit();
    };
}
</script>



					<div class="promo-page ">
                      <div class="b-layout__right b-layout__right_width_72ps b-layout__right_float_right">        
                          <div class="b-menu b-menu_crumbs">
                              <ul class="b-menu__list">
                                  <li class="b-menu__item"><a class="b-menu__link" href="/service/">��� ������ �����</a>&nbsp;&rarr;&nbsp;</li>
                              </ul>
                          </div>
                    	<span title="������� �������" alt="������� �������" class="b-icon b-icon__bpro b-icon__bpro_e" style="position:absolute; left:0;"></span>
                    
						<h1 class="b-page__title">�������� ������ �������� ���� ������������</h1>
						<div class="emp-payed-left-col">
							<div class="emp-promo">
								<b class="b1"></b>
								<b class="b2"></b>
								<div class="emp-promo-in c" style="padding-bottom:0px;">
									<img class="ep-left" src="../images/emp-payed-promo3.png" style="margin-bottom:35px;" alt="" />
									<div class="ep-txt" style="padding-top:10px; padding-bottom:10px;">
										<strong>����������� �������� ���������� � ������ �����������.</strong> �� ������� ������ �������� ���� ������������� �� �����.
									</div>
								</div>
								<b class="b2"></b>
								<b class="b1"></b>
							</div>
							<div class="emp-promo">
								<b class="b1"></b>
								<b class="b2"></b>
								<div class="emp-promo-in c">
									<img src="../images/emp-payed-promo2.png" alt="" class="ep-right" />
									<div class="ep-txt2">
										�������� ����������� <strong>������� ������ ���������� � ����</strong> � �������� &ndash; ��������� ������� � �������� ��������.
									</div>
								</div>
								<b class="b2"></b>
								<b class="b1"></b>
							</div>
							
							<div class="b-fon b-fon_bg_eefee5">
									<b class="b-fon__b1"></b>
									<b class="b-fon__b2"></b>
									<div class="b-fon__body b-fon__body_pad_20 b-layout">
											<h4 class="b-layout__h3 b-layout__h3_padbot_20">��������� ����� �� ��������:</h4>
											<table class="b-layout__table b-layout__table_width_full">
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_fontsize_11">��� ���������� ��������</div></td>
														<td class="b-layout__middle  b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_fontsize_11">��� PRO, ���.</div></td>
														<td class="b-layout__right  b-layout__right_center"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_fontsize_11">� PRO, ���.</div></td>
													</tr>
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_list-style_disc">����������� ������� �����</div></td>
														<td class="b-layout__middle b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5">1500</div></td>
														<td class="b-layout__right b-layout__right_center"><div class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_padbot_5">750</div></td>
													</tr>
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_list-style_disc">�������� ��������</div></td>
														<td class="b-layout__middle b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5">900</div></td>
														<td class="b-layout__right b-layout__right_center"><div class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_padbot_5">600</div></td>
													</tr>
                                                                                                        <?/*
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_list-style_disc">�������� �������</div></td>
														<td class="b-layout__middle b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5">20</div></td>
														<td class="b-layout__right b-layout__right_center"><div class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_padbot_5">10</div></td>
													</tr>*/?>
											</table>
											<div class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_padbot_20">�������� ��� ���������� ������� ��<span class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_fontsize_20">1050</span> ������</div>
											<table class="b-layout__table b-layout__table_width_full">
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_fontsize_11">��� ���������� ���������</div></td>
														<td class="b-layout__middle  b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_fontsize_11">��� PRO, ���.</div></td>
														<td class="b-layout__right  b-layout__right_center"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_fontsize_11">� PRO, ���.</div></td>
													</tr>
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_list-style_disc">���������� ��������</div></td>
														<td class="b-layout__middle b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5">3300</div></td>
														<td class="b-layout__right b-layout__right_center"><div class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_padbot_5">3000</div></td>
													</tr>
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_list-style_disc">����������� ������� �����</div></td>
														<td class="b-layout__middle b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5">1500</div></td>
														<td class="b-layout__right b-layout__right_center"><div class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_padbot_5">750</div></td>
													</tr>
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_list-style_disc">�������� ��������</div></td>
														<td class="b-layout__middle b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5">900</div></td>
														<td class="b-layout__right b-layout__right_center"><div class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_padbot_5">600</div></td>
													</tr>
                                                                                                        <?/*
													<tr class="b-layout__tr">
														<td class="b-layout__left"><div class="b-layout__txt b-layout__txt_padbot_5 b-layout__txt_list-style_disc">�������� ��������</div></td>
														<td class="b-layout__middle b-layout__middle_center"><div class="b-layout__txt b-layout__txt_padbot_5">35</div></td>
														<td class="b-layout__right b-layout__right_center"><div class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_padbot_5">25</div></td>
													</tr>*/?>
											</table>
											<div class="b-layout__txt b-layout__txt_color_fd6c30">�������� ��� ���������� �������� ��<span class="b-layout__txt b-layout__txt_color_fd6c30 b-layout__txt_fontsize_20">1350</span> ������</div>
									</div>
									<b class="b-fon__b2"></b>
									<b class="b-fon__b1"></b>
							</div>
							
							<div class="pricepro10">� ��� ��� ���� �������� PRO ����� <?= payed::PRICE_EMP_PRO; ?> ������ � �����</div>
							
							
							
							
							
						</div>
						<div class="emp-payed-right-col">
                            
						

                            <p>�������� ����������� ������������� �������� ���� ������������� �����, ����������� �������� �� �������������� ������, ���������� ������ ���������� � ���� � ����� ��������.</p>
							<p>������������ � ��������� PRO � ��� �������� �������� �� ����� ���-�����, ������� ��������� ������� ����� ������� �� ����� � ����������� ��������� � ������ ������.</p>
							<p>��������� ������ ��������� � ������ �� ����� ��������� �������� ������� ����������� ����������� � ������������� ������ ������ ����� � ��������� � ������������ ������ ����������� ��������������.</p>
							<p>�������� � ���������������� ��������� ������ ������������ �� ���������� �������� ���-������� � ������ ��� �������� � ������ �������� ������. </p>
                            
							<p><span>*��� ������������� �� ��������, ��� ����� ���, ��� �� ���������� �������� ��������, ��� ��������� �������������. ������� ������ � ��������� ���!</span></p>

							<?php if($uid) { ?>
							<div class="pay-block">
                                <form action="/payed/buy.php" method="post" name="frmbuy" id="frmbuy">
                                <div>

								<div style="overflow:hidden;">
									<div class="b-layout__txt_float_left">
										<span class="pay-inpt b-layout__txt_block"><label for="mnth">���������� �������:</label></span>
										<span class="pay-inpt b-layout__txt_block"><label for="promo-code">�����-���:</label></span>
									</div>
									<div class="b-layout__txt_float_left">
										<span class="pay-inpt b-layout__txt_block">&nbsp;<input type="text" size="3"  name="mnth" id="mnth" value="1" onKeyUp="return (chang(this.value));" /></span>
										<span class="pay-inpt b-layout__txt_block">&nbsp;<input type="text" size="3"  name="promo-code" id="promo-code" value="" /></span>
									</div>
								</div>
								
								<div class="b-layout_clear_both">		
									<div class="pay-inpt" id="it" style="margin-top:20px;">����� � ������: <span><?= payed::PRICE_EMP_PRO; ?></span> ������</div>
                                	<div id="error" class="error <? if ($error) { ?>vis<? } ?>"><?=view_error3("������������ �������. � ������ ������ �� ����� ".round($account->sum,2)."&nbsp;" . ending($account->sum, '�����', '�����', '������') . "<br /> <a href=\"/bill/\" class=\"blue\">��������� ����</a>")?><br /></div>
                                </div>
                                
								<div>
                                    <a class="b-button b-button_round_green" href="javascript:void(0)" name="buy" id="buy" onclick="if (!this.hasClass('b-button_round_color_disable')) {this.addClass('b-button_round_color_disable'); $('frmbuy').submit();}">
                                        <span class="b-button__b1">
                                            <span class="b-button__b2">
                                                <span class="b-button__txt">��������</span>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="b-layout__txt b-layout__txt_padtop_10">
                                       <span class="b-buttons__txt">���</span> &#160; <a class="b-buttons__link b-buttons__link_fontsize_13" href="#">�������� � ������ �������</a>
                                    </div>
                                </div>

                				<input type="hidden" name="transaction_id" value="<?=$transaction_id?>" />
                				<input type="hidden" name="action" value="buy" />
                                </div>
                                </form>
							</div>

                            <? if($user->is_pro=='t') {?>
							<div class="pay-block">
                                <a name="pro_autoprolong"></a>
								<h4>�������������&nbsp;&nbsp;<span class="b-icon b-icon__pro b-icon__pro_e8 b-icon_top_null"></span></h4>
								<p>������ ��� �� ����� ������� �� ������ ��������<br />�������� PRO.<br />��� ��������� ������ ����� � ������ ����� ���������� ����� ����������� <?= payed::PRICE_EMP_PRO?> ������ (��� �� ������� �� ����� ������ �����).</p>
								<div>
                                    <? if($u_is_pro_auto_prolong=='t') { ?>
                                        <a class="b-button b-button_round_green" href="javascript:void(0)" onClick="location='/payed-emp/?pro_auto_prolong=off#pro_autoprolong';">
                                            <span class="b-button__b1">
                                                <span class="b-button__b2">
                                                    <span class="b-button__txt">���������</span>
                                                </span>
                                            </span>
                                        </a>
                                    <? } else { ?>
                                        <a class="b-button b-button_round_green" href="javascript:void(0)" onClick="location='/payed-emp/?pro_auto_prolong=on#pro_autoprolong';">
                                            <span class="b-button__b1">
                                                <span class="b-button__b2">
                                                    <span class="b-button__txt">��������</span>
                                                </span>
                                            </span>
                                        </a>
                                    <? } ?>
                                </div>
							</div>
                            <? } ?>
                            
                            <?php } else { ?>
                            
        <div class="b-fon b-fon_padbot_20">
            <div class="b-fon__body b-fon__body_pad_10 b-fon__body_padleft_30 b-fon__body_fontsize_13 b-fon__body_bg_ffebbf"> <span class="b-fon__attent_pink"></span>����� ������ ������� PRO, ������� ���<br /><a href="/registration/" class="b-layout__link b-layout__link_color_fd6c30">�����������������</a> ��� ������������.</div>
        </div>        
		<div class="b-layout">
        <form action="/" method="post" id="auth_form">
        <table cellspacing="0" cellpadding="0" border="0" class="b-layout__table">
                <tr class="b-layout__tr">
                    <td class="b-layout__one b-layout__one_width_55"><label for="login_inp" class="b-layout__txt b-layout__txt_block b-layout__txt_padtop_5">�����</label></td>
                    <td class="b-layout__one  b-layout__one_padbot_20">
                        <div class="b-combo">
                            <div class="b-combo__input">
                                <input type="text" tabindex="100" name="login" size="80" value="" class="b-combo__input-text" id="login_inp" /><label class="b-combo__label" for="login_inp"></label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="b-layout__tr">
                    <td class="b-layout__one b-layout__one_width_55"><label for="pass_inp" class="b-layout__txt b-layout__txt_block b-layout__txt_padtop_5">������</label></td>
                    <td class="b-layout__one b-layout__one_padbot_20">
                        <div class="b-combo">
                            <div class="b-combo__input">
                                <input type="password" tabindex="101" name="passwd" size="80" value="" class="b-combo__input-text" id="pass_inp" /><label class="b-combo__label" for="pass_inp"></label>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="b-layout__tr">
                    <td class="b-layout__one b-layout__one_width_55">&nbsp;</td>
                    <td class="b-layout__one b-layout__one_padbot_20 b-layout__one_padright_10">
                        <div class="b-check">
                            <input type="checkbox" tabindex="102" name="autologin" value="1" class="b-check__input" id="remember" />
                            <label class="b-check__label b-check__label_fontsize_13" for="remember">��������� ������</label>
                        </div>
                    </td>
                </tr>
        </table>
    
                
        <div class="b-buttons b-buttons_padleft_57">
            <a tabindex="103" href="javascript:void()" onclick="alowLogin(); return false;" class="b-button b-button_valign_top b-button_rectangle_color_green">
                <span class="b-button__b1">
                    <span class="b-button__b2">
                        <span class="b-button__txt">�����</span>
                    </span>
                </span>
            </a>
            &nbsp;&nbsp;
            <div class="b-buttons__txt"><a href="/remind/" class="b-buttons__link">������������ ������</a> <span class="b-buttons__txt">���</span><br /> <a href="/registration/" class="b-buttons__link b-buttons__link_color_fd6c30">������������������</a></div>
        </div>
        <input type="hidden" value="login" name="action">
        <input type="hidden" value="/payed-emp/" name="redirect">										
        </form>
    </div>   
     <?}//else?>
                            
                            
                            
						</div>
						</div>
                    </div>



<?php if($uid) { ?>
<script type="text/javascript">
<!--
chang(document.getElementById('mnth').value);
//-->
</script>
<?php } ?>


