README FIRST
-----------------------

[mlimg]
[xlang:en]

= Tell a Friend =

It is hard to use the link for "Tell a friend" with multi-byte languages.

Even with sigle-byte language, "mailto:" is not useful in the environments without MUA. eg) Internet Cafe

Thus I've made a module of Form Mail working with a Smarty plugin collaboratively.

After you install this, a visitor can send e-mails to his friends by Form mail when he just click the icon.

USAGE:

- Install this module as usual.

- Check "access rights" by groups admin in TellAFriend's admin

- Copy modifier.xoops_tellafriend.php into class/smarty/plugins/
 (this step can be skipped if you use it for native tellafriend modules)

- Edit the templates with links of "Tell a friend" as follows.
- Or turn "use tellafriend module" on in the preferences of the module which is made as a native with "tellafriend")



NOTE:
For anti-spam, I've made a restriction to send mails per IP or uid.
If you want to change, go to preferences of TellAFriend's admin.



SAMPLES of editing the templates.

[b]news[/b]
news_article.html
[code]
[d]<a target="_top" href="<{$mail_link}>">[/d]
<a target="_top" href="<{$mail_link|xoops_tellafriend}>">
[/code]
news_archive.html
[code]
[d]<a href="<{$story.mail_link}>" target="_top" />[/d]
<a href="<{$story.mail_link|xoops_tellafriend}>" target="_top" />
[/code]

[b]mylinks[/b]
mylinks_link.html
[code]
[d]<a target="_top" href="mailto:?subject=<{$link.mail_subject}>&amp;body=<{$link.mail_body}>">[/d]
<a target="_top" href="<{$link.mail_body|xoops_tellafriend:$link.mail_subject}>">
[/code]

[b]mydownloads[/b]
mydownloads_download.html
[code]
[d]<a target="_top" href="mailto:?subject=<{$down.mail_subject}>&amp;body=<{$down.mail_body}>">[/d]
<a target="_top" href="<{$down.mail_body|xoops_tellafriend:$down.mail_subject}>">
[/code]

[b]Tellafriend native modules (pico, bulletin etc.)[/b]
Go to the preferences, and just turn 'Use tellafriend module' on.




[/xlang:en]
[xlang:ja]

= Tell a Friend =

����������Ϥ���ޤ���������ͧã���Τ餻��פ�mailto:�ǹԤ��Τϡ��ɤ���äƤ��ʸ�������פ��򤱤��ʤ��Ȥ����Τ������Ǥ���

�ޤ����᡼�顼�����åȥ��åפ���Ƥ���Ķ�����Υ��������ʤ�Ȥ⤫�������󥿡��ͥåȥ��ե��ʤɤ���Ǥϡ�mailto:�ϰ�̣������ޤ���


�Ȥ����櫓�ǡ�Smarty plug-in �Ȥ��Ȥ߹�碌�ǡ��ե�����᡼������Ѥ���⥸�塼����äƤߤޤ�����


���Υ⥸�塼���������ˡ�Ǥ��������Ĥμ�礬ɬ�פǤ���

- �ޤ������̤˥��󥹥ȡ��뤷�Ƥ���������

- class/smarty/plugins/ �� modifier.xoops_tellafriend.php �򥳥ԡ����Ƥ�������
�ʺǽ餫���б����Ƥ���⥸�塼������Ѥ���������פǤ���

- ��ͧã���Τ餻��ץ�󥯤Τ���ƥ�ץ졼�Ȥ��Խ����Ƥ���������
�ʺǽ餫���б����Ƥ���⥸�塼��Ǥ���С�����������ѹ���Ԥ��ޤ���


�����Ȥ˵��Ĥ��������ϡ����롼�״������顢�����Ȥ��Ф��ƥ⥸�塼�륢���������¤�Ϳ���Ƥ���������
���ѥ�����Ƨ����ˤ���ʤ��褦��IP��⤷����uid������������¤��ߤ��Ƥ���ޤ��Τǡ�ɬ�פ˱����ơ��ְ�������פ����ѹ����Ƥ���������


------------------------------------------------------------------
�ʲ��˥ƥ�ץ졼���Խ��Υ���ץ�򼨤��ޤ���

[b]news[/b]
news_artcle.html
[code]
[d]<a target="_top" href="<{$mail_link}>">[/d]
<a target="_top" href="<{$mail_link|xoops_tellafriend}>">
[/code]
news_archive.html
[code]
[d]<a href="<{$story.mail_link}>" target="_top" />[/d]
<a href="<{$story.mail_link|xoops_tellafriend}>" target="_top" />
[/code]

[b]mylinks[/b]
mylinks_link.html
[code]
[d]<a target="_top" href="mailto:?subject=<{$link.mail_subject}>&amp;body=<{$link.mail_body}>">[/d]
<a target="_top" href="<{$link.mail_body|xoops_tellafriend:$link.mail_subject}>">
[/code]

[b]mydownloads[/b]
mydownloads_download.html
[code]
[d]<a target="_top" href="mailto:?subject=<{$down.mail_subject}>&amp;body=<{$down.mail_body}>">[/d]
<a target="_top" href="<{$down.mail_body|xoops_tellafriend:$down.mail_subject}>">
[/code]

[b]Tellafriend�б��⥸�塼��ξ�� (pico��bulletin��)[/b]
�����⥸�塼��ΰ�������ǡ���Tell a Friend�⥸�塼���Ȥ��פ�֤Ϥ��פȤ��ޤ���


[/xlang:ja]

CHANGES:

v1.05 2008-12-08
- updated README
- updated mymenu
- added language files
-- portuguesebr (thx leco1)

v1.04 2008-12-05
- modified the compatibilities with XCL2.1
- modified MySQL5 compatibility
- changed altsys friendly module

v1.03 2006-07-13
- modified xoops_version.php as hasMain=1 (thx Rollei)
- added language files
-- persian (thx voltan) 1.03a

v1.02 2005-12-03
- updated myblocksadmin 0.41 & mymenu 0.15a
- updated module icon (thx argon)

v1.01 2005-07-21
- fixed a bug in JavaScript (thx yamaichi)

v1.00 2005-05-25
- the 1st release



