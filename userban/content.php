<?
if(!defined('IN_STDF')) { 
    header("HTTP/1.0 404 Not Found");
    exit();
}
if (hasPermissions('users')) {
    ?>  
    <table width="100%"><tr><td style="padding-left:50px;">
<h1>�� ������ ������������ 
<a href="/users/<?=$usr->login?>" class="<?=(is_emp($usr->role)?"emp":"frl")?>name11"><?=view_avatar($usr->login, $usr->photo)?></a>
<a href="/users/<?=$usr->login?>" class="<?=(is_emp($usr->role)?"emp":"frl")?>name11"><?=$usr->uname?> <?=$usr->usurname?> [<?=$usr->login?>]</a></h1> 
<b>��� �����:</b>
<br><br>
<form method="POST" action="." >
<input type="hidden" name="no_send" value="<?=(isset($_GET["no_send"])?1:0)?>">
<input type="radio" name="where" id="where1" value="0" <?=(!$_GET["where"] ? 'checked' : '')?>> <label for="where1">�����</label><br>
<?php if ($bIsWhere): ?>
<input type="radio" name="where" id="where2" value="1" <?=($_GET["where"]==1 ? 'checked' : '')?>> <label for="where2">� ������</label> <br>
<?php endif; ?>

<br><br>
<b>�������:</b>
<br>
<!--<input type="radio" name="reason" id="reason1" value="1" checked> <label for="reason1">������ ������������ ��������� �� �����</label> <br>-->
<input type="radio" name="reason" id="reason2" value="2" > <label for="reason2">���� � ������</label> <br>
<input type="radio" name="reason" id="reason3" value="3" > <label for="reason3">���� � ��������</label> <br>
<input type="radio" name="reason" id="reason4" value="4" > <label for="reason4">������� ������</label> <br>
<br><br>
<b><input type="radio" name="alltime" id="alltime1" value="1" checked> <label for="alltime1">��������</label><?php if ($bIsTime): ?> <input type="radio" name="alltime" id="alltime2" value="0"> <label for="alltime2">��� ��</label> <input type="text" size="3" name="time" maxlength="2" value="7"> ����</b><?php endif; ?><br><br>
<b>�����������:</b><br>
<textarea  cols="50" rows="10" name="comment"></textarea><br>
<br>
������� � ����������� ���� ����������� � ������� ����� � �������.<br>
<br>
<?php if ( intval($_GET['no_send']) == 0 ): ?>
������������ ������� ��������� �� ������������� ������� �� ��� �������� �����.<br>
<br>
<?php endif; ?>
�� ��������� ����, ������������ ������� ������ � ������ ��������.
��� ��������� �� ���� � ����� � ������� ����� ����� � ����������.
<?
if ($sbrs) {
?><br>
<h1 class="public_red_normal">��������! ���� ������������ ��������� � ����������� ��������!</h1><br/>
<ul><? foreach ($sbrs as $s) { ?>
	<li style="margin-bottom:20px;"><a href="/norisk2/?id=<?=$s->id?>&access=A&<?=$s->isEmp() ? 'E' : 'F'?>=<?=$s->login?>" class="blue"><?=$s->name?></a><br/>
	<? if($s->reserved_id) { ?>������ ��������������� <?=date('j '.strtolower($MONTHA[date('n', strtotime($s->reserved_time))]).' Y ���� � H:i', strtotime($s->reserved_time))?>
	<? } else { ?>������ �� ���������������<? } ?><br/>
	���� ���������� �������: <?=$s->work_days?> <?=ending(abs($s->work_days), '����', '���', '����')?>.<br/>
	<? if (is_emp($usr->role)) { ?>
	���������: <a href="/users/<?=$s->frl_login?>" class="frlname11"><?=$s->frl_uname?> <?=$s->frl_usurname?> [<?=$s->frl_login?>]</a>
	<? } else { ?>
	��������: <a href="/users/<?=$s->emp_login?>" class="empname11"><?=$s->emp_uname?> <?=$s->emp_usurname?> [<?=$s->emp_login?>]</a>
	<? } ?></li>
<? } ?></ul>

<? } ?>
<br><input type="hidden" name="uid" value="<?=$usr->login?>"><input type="hidden" name="blogid" value="<?=htmlspecialchars($_GET["blogid"])?>">
<br><input type="hidden" name="returnpath" value="<?=($_GET["returnpath"] ? htmlspecialchars($_GET["returnpath"])  :  htmlspecialchars($_SERVER["HTTP_REFERER"]))?>">
<div align="center"><input type="submit" value="��������"></div>
</form>
</td> </tr> </table>  
<?
}
?>
