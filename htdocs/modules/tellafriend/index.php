<?php
// $Id: index.php,v 1.7 2003/03/26 04:42:53 okazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
// ------------------------------------------------------------------------- //
//  This program is free software; you can redistribute it and/or modify     //
//  it under the terms of the GNU General Public License as published by     //
//  the Free Software Foundation; either version 2 of the License, or        //
//  (at your option) any later version.                                      //
//                                                                           //
//  You may not change or alter any portion of this comment or credits       //
//  of supporting developers from this source code or any supporting         //
//  source code which is considered copyrighted (c) material of the          //
//  original comment or credit authors.                                      //
//                                                                           //
//  This program is distributed in the hope that it will be useful,          //
//  but WITHOUT ANY WARRANTY; without even the implied warranty of           //
//  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the            //
//  GNU General Public License for more details.                             //
//                                                                           //
//  You should have received a copy of the GNU General Public License        //
//  along with this program; if not, write to the Free Software              //
//  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307 USA //
//  ------------------------------------------------------------------------ //

include "../../mainfile.php";
include "include/gtickets.php";

$myts =& MyTextSanitizer::getInstance();

/* if( ! is_object( $xoopsUser ) ) {
	redirect_header( XOOPS_URL . '/user.php' , 3 , _NOPERM ) ;
	exit ;
}*/

if( file_exists( dirname( __FILE__ ) . '/language/' . $xoopsConfig['language'] . '/modinfo.php' ) ) {
	include_once dirname( __FILE__ ) . '/language/' . $xoopsConfig['language'] . '/modinfo.php' ;
} else {
	include_once dirname( __FILE__ ) . '/language/english/modinfo.php' ;
}


/******************* MAIL PART **********************/
if( ! empty($_POST['submit']) ) {

	// Ticket Check
/*	if ( ! $xoopsGTicket->check() ) {
		redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
	}*/

	// anti-spam
	if( ! is_object( $xoopsUser ) ) {
		// ip base restriction for guest
		$result = $xoopsDB->query( "SELECT count(*) FROM ".$xoopsDB->prefix("tellafriend_log")." WHERE ip='{$_SERVER['REMOTE_ADDR']}' AND timestamp > NOW() - INTERVAL 1 DAY" ) ;
		list( $count ) = $xoopsDB->fetchRow( $result ) ;
		if( $count >= $xoopsModuleConfig['max4guest'] ) {
			redirect_header( XOOPS_URL.'/' , 3 , _MI_TELLAFRIEND_TOOMANY ) ;
			exit ;
		}
	} else if( ! $xoopsUser->isAdmin() ) {
		// uid base restriction for non-admin user
		$uid = $xoopsUser->getVar( 'uid' ) ;
		$result = $xoopsDB->query( "SELECT count(*) FROM ".$xoopsDB->prefix("tellafriend_log")." WHERE uid='$uid' AND timestamp > NOW() - INTERVAL 1 DAY" ) ;
		list( $count ) = $xoopsDB->fetchRow( $result ) ;
		if( $count >= $xoopsModuleConfig['max4user'] ) {
			redirect_header( XOOPS_URL.'/' , 3 , _MI_TELLAFRIEND_TOOMANY ) ;
			exit ;
		}
	}

	$redirect_uri = ! empty( $_SESSION['tellafriend_referer'] ) && stristr( $_SESSION['tellafriend_referer'] , XOOPS_URL ) ? $_SESSION['tellafriend_referer'] : XOOPS_URL."/index.php" ;
	unset( $_SESSION['tellafriend_referer'] ) ;

	if( is_object( $xoopsUser ) ) {
		$users_name = $xoopsUser->getVar("uname") ;
		$users_email = $xoopsUser->getVar("email") ;
		$users_subject = xoops_substr( $myts->stripSlashesGPC($_POST['usersSubject']) , 0 , 200 , '' ) ;
		$uid = $xoopsUser->getVar( 'uid' ) ;
	} else {
		$users_name = xoops_substr( $myts->stripSlashesGPC($_POST['fromName']) , 0 , 200 , '' ) ;
		$users_email = xoops_substr( $myts->stripSlashesGPC($_POST['fromEmail']) , 0 , 200 , '' ) ;
		$users_subject = $_SESSION['usersSubject'] ;
		unset( $_SESSION['usersSubject'] ) ;
		// check if from_email is valid as an email address
		if( ! preg_match( '/^[\w\-\.]+\@[\w\-]+\.[\w\-\.]+$/' , $users_email ) ) {
			redirect_header( $redirect_uri , 3 , _MI_TELLAFRIEND_INVALIDMAILFROM ) ;
			exit ;
		}
		$uid = 0 ;
	}

	$users_to = xoops_substr( $myts->stripSlashesGPC($_POST['usersTo']) , 0 , 200 , '' ) ;
	$users_comments = xoops_substr( $myts->stripSlashesGPC($_POST['usersComments']) , 0 , 4096 , '' ) ;

	// check if users_to is valid as an email address
	if( ! preg_match( '/^[\w\-\.]+\@[\w\-]+\.[\w\-\.]+$/' , $users_to ) ) {
		redirect_header( $redirect_uri , 3 , _MI_TELLAFRIEND_INVALIDMAILTO ) ;
		exit ;
	}

	$message_body = sprintf(_MI_TELLAFRIEND_MAILBODYNAME,$users_name);
	$message_body .= "---------------\n\n";
	$message_body .= "$users_comments\n\n";
	$message_body .= "---------------\n";
	$message_body .= "{$xoopsConfig['sitename']} ".XOOPS_URL."/\n\n";
	if( ! is_object( $xoopsUser ) ) $message_body .= "Sender IP: {$_SERVER['REMOTE_ADDR']}";

	$xoopsMailer =& getMailer();
	$xoopsMailer->useMail();
	$xoopsMailer->setToEmails($users_to);
	$xoopsMailer->setFromEmail($users_email);
	$xoopsMailer->setFromName($users_name);
	$xoopsMailer->setSubject($users_subject);
	$xoopsMailer->setBody($message_body);
	$send_result = $xoopsMailer->send();

	if( $send_result ) {
		$xoopsDB->query(
			"INSERT INTO ".$xoopsDB->prefix("tellafriend_log")." SET "
			."uid='$uid',"
			."ip='{$_SERVER['REMOTE_ADDR']}',"
			."mail_fromname='".addslashes( $users_name )."',"
			."mail_fromemail='".addslashes( $users_email )."',"
			."mail_to='".addslashes( $users_to )."',"
			."mail_subject='".addslashes( $users_subject )."',"
			."mail_body='".addslashes( $message_body )."',"
			."agent='".addslashes( $_SERVER['HTTP_USER_AGENT'] )."'"
		) ;
		redirect_header( $redirect_uri , 1 , _MI_TELLAFRIEND_MESSAGESENT ) ;
	} else {
		redirect_header( $redirect_uri , 3 , _MI_TELLAFRIEND_SENDERROR ) ;
	}

	exit ;
}


/******************* FORM PART **********************/

//$xoopsOption['template_main'] = 'tellafriend_form.html'; disable module cache
include XOOPS_ROOT_PATH."/header.php";
$xoopsOption['template_main'] = 'tellafriend_form.html';
include_once XOOPS_ROOT_PATH."/class/xoopsformloader.php";

$_SESSION['tellafriend_referer'] = @$_SERVER['HTTP_REFERER'] ;

$subject = empty( $_GET['subject'] ) ? sprintf( _MI_TELLAFRIEND_DEFAULTSUBJ , $xoopsConfig['sitename'] ) : $myts->stripSlashesGPC( $_GET['subject'] ) ;
$subject4show = htmlspecialchars( $subject , ENT_QUOTES ) ;

$comment = empty( $_GET['target_uri'] ) ? '' : sprintf( _MI_TELLAFRIEND_DEFAULTBODY , $myts->stripSlashesGPC( $_GET['target_uri'] ) ) ;
$comment4show = htmlspecialchars( $comment , ENT_QUOTES ) ;

if( ! is_object( $xoopsUser ) ) {
	$fromname_text = new XoopsFormText( _MI_TELLAFRIEND_FORMTHFROMNAME , "fromName" , 30 , 100 , '' ) ;
	$fromemail_text = new XoopsFormText( _MI_TELLAFRIEND_FORMTHFROMEMAIL , "fromEmail" , 40 , 100 , '' ) ;
	$_SESSION['usersSubject'] = $subject ;
	$subject_text = new XoopsFormLabel( _MI_TELLAFRIEND_FORMTHSUBJ , $subject4show ) ;
} else {
	$subject_text = new XoopsFormText( _MI_TELLAFRIEND_FORMTHSUBJ , "usersSubject", 50, 100 , $subject4show ) ;
}

$to_text = new XoopsFormText( _MI_TELLAFRIEND_FORMTHTO , "usersTo", 40, 100, '');

$body_label = new XoopsFormLabel( _MI_TELLAFRIEND_FORMTHBODY , nl2br( $comment4show ) ) ;
$body_hidden = new XoopsFormHidden( "usersComments", $comment4show ) ;
$comment_textarea = new XoopsFormTextArea( _MI_TELLAFRIEND_FORMTHBODY , "usersComments", $comment4show , 10 , 40 ) ;

$ticket_hidden = $xoopsGTicket->getTicketXoopsForm( __LINE__ ) ;
$submit_button = new XoopsFormButton( "" , "submit" , _MI_TELLAFRIEND_BUTTONSEND , "submit" ) ;


$contact_form = new XoopsThemeForm( _MI_TELLAFRIEND_FORMTITLE , "tf_form" , "index.php" ) ;
$contact_form->addElement($to_text, true);

if( ! is_object( $xoopsUser ) ) {
	$contact_form->addElement($fromname_text, true);
	$contact_form->addElement($fromemail_text, true);
}

$contact_form->addElement($subject_text);
if( $xoopsModuleConfig['can_bodyedit'] ) {
	$contact_form->addElement($comment_textarea, true);
} else {
	$contact_form->addElement($body_label);
	$contact_form->addElement($body_hidden);
}
$contact_form->addElement($ticket_hidden);
$contact_form->addElement($submit_button);
$contact_form->assign($xoopsTpl);
include XOOPS_ROOT_PATH."/footer.php";



?>