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

いろいろ議論はありましたが、「友達に知らせる」をmailto:で行うのは、どうやっても「文字化け」は避けられないというのが結論です。

また、メーラーがセットアップされている環境からのアクセスならともかく、インターネットカフェなどからでは、mailto:は意味がありません。


というわけで、Smarty plug-in との組み合わせで、フォームメールを利用するモジュールを作ってみました。


このモジュールの利用方法ですが、３つの手順が必要です。

- まず、普通にインストールしてください。

- class/smarty/plugins/ に modifier.xoops_tellafriend.php をコピーしてください
（最初から対応しているモジュールに利用する場合は不要です）

- 「友達に知らせる」リンクのあるテンプレートを編集してください。
（最初から対応しているモジュールであれば、一般設定の変更を行います）


ゲストに許可したい場合は、グループ管理から、ゲストに対してモジュールアクセス権限を与えてください。
スパム等の踏み台にされないよう、IP毎もしくはuid毎に送信数制限を設けてありますので、必要に応じて、「一般設定」から変更してください。


------------------------------------------------------------------
以下にテンプレート編集のサンプルを示します。

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

[b]Tellafriend対応モジュールの場合 (picoやbulletin等)[/b]
該当モジュールの一般設定で、「Tell a Friendモジュールを使う」を「はい」とします。


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



