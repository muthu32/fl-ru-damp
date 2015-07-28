<?php

/**
 * ������� �� ���������� �� ���� ���������, ������� ������������� ������ ����������� ����� ��������. 
 */
class temp_email {
    /**
     * ������ ��������, ������� ������������� ������ ����������� ����� ��������
     *
     * @var array
     */
    static $aServices = array(
        '10minutemail.com', 
        '2prong.com', 
        'abcdefghijklmnopqrstuvwxyzabcdefghijklmnopqrstuvwxyzabcdefghijk.com',
        'animail.su', 
        'antireg.ru', 
        'asdasd.ru', 
        'disposableinbox.com',
        'dodgit.com', 
        'donemail.ru',
        'fakedemail.com', 
        'fakeinbox.com', 
        'hmamail.com',
        'guerrillamail.com', 
        'guerrillamailblock.com', 
        'insorg-mail.info', 
        'incognitomail.com',
        'incognitomail.org',
        'jetable.org',
        'key-mail.net',
        'klzlk.com', 
        'kurzepost.de', 
        'kurzepost.de', 
        'lawlita.com', 
        'mail4trash.com', 
        'mailblock.com', 
        'maileater.com', 
        'mailexpire.com',
        'mailforspam.com', 
        'mailin8r.com', 
        'mailinator.com', 
        'mailinator.net', 
        'mailinator2.com', 
        'mailmetrash.com', 
        'mailcatch.com',
        'mail-it24.com',
        'meltmail.com',
        'mbx.cc',
        'mintemail.com', 
        'mt2009.com', 
        'mytempemail.com',
        'mytrashmail.com', 
        'no-spam.ws', 
        'objectmail.com', 
        'odnorazovoe.ru', 
        'oneoffmail.com', 
        'otherinbox.com', 
        'owlpic.com', 
        'pjjkp.com', 
        'pookmail.com', 
        'privy-mail.com', 
        'proxymail.eu', 
        'rapidmailbox.com',
        'rcpt.at', 
        'shitmail.me', 
        'slopsbox.com', 
        'sogetthis.com', 
        'spam.la', 
        'spam.su', 
        'spamavert.com', 
        'spamfree24.org',
        'spambog.com', 
        'spambog.ru',
        'spamobox.com',
        'spambox.us', 
        'spamgourmet.com', 
        'spamherelots.com', 
        'spamhole.com', 
        'spaml.com', 
        'tempemail.net', 
        'tempinbox.com', 
        'tempomail.fr', 
        'temporaryinbox.com', 
        'thankyou2010.com', 
        'thisisnotmyrealemail.com', 
        'thisisnotmyrealemail.com', 
        'thismail.ru', 
        'trash2009.com', 
        'trashmail.at', 
        'trash-mail.at', 
        'trash-mail.com', 
        'trashmail.me', 
        'trashmail.net', 
        'trashymail.com', 
        'wegwerfmail.com',
        'wegwerfmail.de', 
        'wegwerfmail.net', 
        'wegwerfmail.org', 
        'wh4f.org', 
        'wwwnew.eu',
        'yopmail.com',
        'sharklasers.com',
        'nepwk.com',
        'privy-mail.de',
        'fansworldwide.de',
        'fatflap.com',
        'dingbone.com',
        'fudgerub.com',
        'beefmilk.com',
        'lookugly.com',
        'smellfear.com',
        'zmail.ru',
        'id.ru',
        'go.ru',
        'ru.ru',
        'quake.ru',
        'antireg.com',
        'rppkn.com',
        'sendanonymousemail.net',
        'despammed.com',
        'discardmail.com',
        'discardmail.de',
        'spambog.de',
        'e4ward.com',
        'hushmail.com',
        'noclickemail.com',
        'temporaryemail.us',
        'spamspot.com',
        'bobmail.info',
        'msb.mailslite.com',
        'rtrtr.com',
        'llogin.ru',
        'mailspeed.ru',
        'chammy.info',
        'csproject.org',
        'twilightparadox.com',
        'svlen.ru',
        'linuxd.org',
        'ez.lv',
        'strangled.net',
        'r-o-o-t.net',
        'keren.la',
        'ftp.sh',
        '55.lt',
        'leet.la',
        'kir22.ru',
        'mooo.com',
        'shop.tm',
        'izvor.ru',
        'tradermail.info',
        'chickenkiller.com',
        'safetymail.info',
        'zippymail.info',
        '120v.ac',
        '404.mn',
        '69.mu',
        'allez.la',
        'awiki.org',
        'bad.mn',
        'bum.ms',
        'cf.gs',
        'dicionar.io',
        'encyclopedia.tw',
        'evils.in',
        'fragmentary.info',
        'ham.cx',
        'host2go.net',
        'inc.gs',
        'index.tc',
        'info.gf',
        'jpe.gs',
        'mil.nf',
        'mine.bz',
        'na.tl',
        'now.im',
        'pedie.info',
        'pedija.org',
        'pudim.info',
        'surfnet.ca',
        'sux.ms',
        'uni.cx',
        've3.info',
        'vist.as',
        'voyez.ca',
        'webs.vc',
        'wiki.gd',
        'wiki.gs',
        'vpn-thebest.com',
        'zonby.ks.ua',
        'coupe-cars.ru',
        'moto-technika71.com',
        'tyear.ru',
        'zhenskijmir.com',
        'autostop71.ru',
        'nemigaexport.com',
        'blizzardrc.org',
        'zonby.if.ua'
    );
    
    /**
     * ��������� �� �������� �� ����������� ����� ��������������� ��������.
     *
     * @param  string $sEmail ����� ����������� ����� ��� ��������
     * @return bool true ���� ����� ���������, ����� false
     */
    function isTempEmail( $sEmail = '' ) {
        $aPart = explode( '@', $sEmail );
        return ( (isset($aPart[1]) && in_array(strtolower($aPart[1]), temp_email::$aServices)) ? true : false );
    }
}

?>
