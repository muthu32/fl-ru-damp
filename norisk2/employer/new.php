<div class="tabs-in">
	<div class="nr-empty">
		<div class="nr-txt">
            <h3>������� ����� ����������� ������</h3>
            <p>�� �������������� ���� ��������� �������� �������� ���������� ��� ������ �������:</p>
			<div class="form nr-vars">
				<b class="b1"></b>
				<b class="b2"></b>
				<div class="form-in">
					<div class="form-block first">
                        <h4><a href="/users/<?=$sbr->login?>/setup/projects/">������ ����������� ������ � �������� �������</a></h4>
                        <p>������������ � ������������ � ����� �� ����� �������� � ���������� ��� �������� ����������� ������.<br />
                        <? if($projects_cnt['open']) { ?>
                          �� ������ ������ � ��� <?=$projects_cnt['open'].ending($projects_cnt['open'], ' �������� ������', ' �������� �������', ' �������� ��������')?>, � ����� �� ��� �� ������ ������ ����������� ������.</p>
                        <? } ?>
					</div>
					<div class="form-block">
						<h4><a href="?site=create">������ ����������� ������ ��� ���������� �������</a></h4>
                        <p>��� ������ �� ����� ����������� �� ������� �������� &mdash; ��������� ���� �������, ���� �� ��� ����� ������ �����������.</p>
					</div>
					<div class="form-block last">
						<h4><a href="/public/">����������� ������ � ������������ ����������� ������</a></h4>
                        <p>������� �����������, ����������� ������ � ����� �������� �� ������� �������� �����, � ��������� � ��� ����������� ������.</p>
					</div>
				</div>
				<b class="b2"></b>
				<b class="b1"></b>
			</div>
		</div>
	</div>
</div>
