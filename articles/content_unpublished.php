
<?php
$crumbs = array();
$crumbs[] = array("title"=>"������ � ��������", "url"=>"/articles/");
$crumbs[] = array("title"=>"������ �� ���������", "url"=>"");
?>
<div class="b-menu b-menu_crumbs b-menu_padbot_20"><?=getCrumbs($crumbs)?></div>

<? include($mpath . '/tabs.php'); ?>
<div class="page-articles">
    <div class="p-articles-in c">
        <div class="p-a-cnt b-layout__right b-layout__right_relative b-layout__right_width_72ps b-layout__right_float_right" id="articles_list">
            <? if($articles) foreach($articles as $article) { ?>
            <div class="post-one" id="post_<?=$article['id']?>">
                <? if ($article['fname']) { ?>
                    <img src="<?=WDCPREFIX?>/<?=$article['path']?><?=$article['fname']?>" alt="" width="100" class="post-img" />
                <? } ?>
                <div class="post-txt">
                    <h3><a class="b-layout__link" href="<?=getFriendlyURL('article', $article['id']).($page ? "?p=$page" : "")?>"><?=!$article['title'] ? '��� ��������' : reformat($article['title'], 32, 0, 1) ?></a></h3>
                    <p class="post-body">
                        <?= reformat($article['short'], 50, 0, 0, 1) ?></p>
                </div>
                <div class="post-f c">
                    <ul>
                        <li class="post-f-lnks">
                            <ul>
                                <li class="first">
                                    <? if(hasPermissions('articles')) { ?>
                                    <a href="javascript:void(0)" style="color: #A23E3E;" onclick="editArticle(<?=$article['id']?>)">�������������</a>
                                    &nbsp;|&nbsp;
                                    <a href="javascript:void(0)" style="color: #A23E3E;" onclick="delArticleForm(<?=$article['id']?>);">�������</a>
                                    &nbsp;|&nbsp;
                                    <? } ?>
                                    <? if($article['approved'] == 'f' && (hasPermissions('articles'))) { ?>
                                    <a href="javascript:void(0)" style="color: #A23E3E;" class="moderator_decline" article_id="<?= $article['id'] ?>">���������</a>
                                    &nbsp;|&nbsp;
                                    <a href="javascript:void(0)" class="moderator_approve" article_id="<?= $article['id'] ?>">�����������</a>
                                    <? } ?>
                                </li>
                            </ul>
                        </li>

                        <li class="post-f-date">
                            <?=date('d.m.Y � H:i', strtotime($article['moderation_time']))?>
                        </li>
                        <li class="post-f-autor">
                            <a href="/users/<?=$article['login']?>">
                <?= $article['uname'] . ' ' . $article['usurname'] . ' [' . $article['login'] . ']'?>
                            </a>
														<span class="post-f-autor-grad"></span>
                        </li>
                    </ul>
                </div>
            </div>
            <? } ?>
            
            <? if (hasPermissions('articles')) { ?>
                <form method="post" id="moderator_form">
                    <input type="hidden" name="u_token_key" value="<?= $_SESSION['rand'] ?>" />
                    <input type="hidden" name="task" id="moderator_form_task" />
                    <input type="hidden" name="id" id="moderator_form_article_id" />
                </form>
            <? } ?>
            
            <?=new_paginator($page, $pages, 3, "%s?".urldecode(url('ord,p,page', array('p' => '%d')))."%s")?>
            <? if(hasPermissions('articles')) include('form.php'); ?>
        </div>
        <div class="p-a-left b-layout__left b-layout__left_width_25ps">
            <div class="p-a-popular c">
            </div>
            <div class="favorites">
            </div>
            <!-- Banner 240x400 -->
                <?= printBanner240(is_pro(), true); ?>
            <!-- end of Banner 240x400 -->
        </div>
    </div>
</div>

<div id="del-article-form" class="form fs-o form-adel" style="display: none;">
    <b class="b1"></b>
    <b class="b2"></b>
    <div class="form-in">
                    <form id="del_article_frm" method="post" action="/articles/?task=del-article">
        <div class="form-block first last">
                <h4>�������� ������</h4>
            <div class="form-el">
                <label class="form-label2">������� ������� ������ � ���������� (��� ������):</label>
                <div class="form-value">
                        <input type="hidden" name="id" value="" />
                        <textarea rows="5" cols="20" name="msgtxt"></textarea>
                        <div class="form-btns">
                            <button onclick="return delArticleConfirm()">�������</button>&nbsp; <a href="javascript:void(0)" onclick="delArticleFormClose()" class="lnk-dot-666">��������</a>
                        </div>
                </div>
            </div>
        </div>
                    </form>
    </div>
    <b class="b2"></b>
    <b class="b1"></b>
</div>
