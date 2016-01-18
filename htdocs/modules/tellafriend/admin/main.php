<?php
require_once '../../../include/cp_header.php' ;
require_once '../include/gtickets.php' ;
include_once 'admin_header.php';
define( '_MYMENU_CONSTANT_IN_MODINFO' , '_MI_TELLAFRIEND_MODNAME' ) ;

// branch for altsys
if( defined( 'XOOPS_TRUST_PATH' ) && ! empty( $_GET['lib'] ) ) {
    $mydirname = basename( dirname( dirname( __FILE__ ) ) ) ;
    $mydirpath = dirname( dirname( __FILE__ ) ) ;

    // common libs (eg. altsys)
    $lib = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , $_GET['lib'] ) ;
    $page = preg_replace( '/[^a-zA-Z0-9_-]/' , '' , @$_GET['page'] ) ;

    if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/'.$page.'.php' ) ) {
        include XOOPS_TRUST_PATH.'/libs/'.$lib.'/'.$page.'.php' ;
    } else if( file_exists( XOOPS_TRUST_PATH.'/libs/'.$lib.'/index.php' ) ) {
        include XOOPS_TRUST_PATH.'/libs/'.$lib.'/index.php' ;
    } else {
        die( 'wrong request' ) ;
    }
    exit ;
}

// GET vars
$pos = empty( $_GET[ 'pos' ] ) ? 0 : intval( $_GET[ 'pos' ] ) ;
$num = empty( $_GET[ 'num' ] ) ? 20 : intval( $_GET[ 'num' ] ) ;

// Table Name
$log_table = $xoopsDB->prefix( "tellafriend_log" ) ;

// UPDATE stage
if( ! empty( $_POST['action'] ) ) {
    if( $_POST['action'] == 'delete' && isset( $_POST['ids'] ) && is_array( $_POST['ids'] ) ) {
        // Ticket check
        if ( ! $xoopsGTicket->check() ) {
            redirect_header(XOOPS_URL.'/',3,$xoopsGTicket->getErrors());
        }

        // remove records
        foreach( $_POST['ids'] as $lid ) {
            $lid = intval( $lid ) ;
            $xoopsDB->query( "DELETE FROM $log_table WHERE lid='$lid'" ) ;
        }
        redirect_header( "main.php" , 2 , _AM_MSG_REMOVED ) ;
        exit ;
    }
}

// query for listing
$rs = $xoopsDB->query( "SELECT count(lid) FROM $log_table" ) ;
list( $numrows ) = $xoopsDB->fetchRow( $rs ) ;
$prs = $xoopsDB->query( "SELECT l.lid, l.uid, l.ip, l.agent, l.mail_fromemail, l.mail_to, UNIX_TIMESTAMP(l.timestamp), u.uname FROM $log_table l LEFT JOIN ".$xoopsDB->prefix("users")." u ON l.uid=u.uid ORDER BY timestamp DESC LIMIT $pos,$num" ) ;

// Page Navigation
require_once XOOPS_ROOT_PATH.'/class/pagenav.php' ;
$nav = new XoopsPageNav( $numrows , $num , $pos , 'pos' , "num=$num" ) ;
$nav_html = $nav->renderNav( 10 ) ;

// beggining of Output
xoops_cp_header();
//include( './mymenu.php' );

$indexAdmin = new ModuleAdmin();

echo $indexAdmin->addNavigation('main.php');

// check $xoopsModule
if( ! is_object( $xoopsModule ) ) redirect_header( XOOPS_URL.'/user.php' , 1 , _NOPERM ) ;

// title
//echo "<h3 style='text-align:left;'>".$xoopsModule->name()."</h3>\n" ;

// header of log listing
echo "
<table width='95%' border='0' cellpadding='4' cellspacing='0'><tr><td>
<form action='' method='GET' style='margin-bottom:0px;text-align:right'>
  $nav_html &nbsp;
</form>
<form name='MainForm' action='' method='POST' style='margin-top:0px;'>
".$xoopsGTicket->getTicketHtml(__LINE__)."
<input type='hidden' name='action' value='' />
<table width='95%' class='outer' cellpadding='4' cellspacing='1'>
  <tr valign='middle'>
    <th width='5'><input type='checkbox' name='dummy' onclick=\"with(document.MainForm){for(i=0;i<length;i++){if(elements[i].type=='checkbox'){elements[i].checked=this.checked;}}}\" /></th>
    <th>"._AM_TH_DATETIME."</th>
    <th>"._AM_TH_USER."</th>
    <th>"._AM_TH_IP."<br />"._AM_TH_AGENT."</th>
    <th>"._AM_TH_MAIL_FROM."</th>
    <th>"._AM_TH_MAIL_TO."</th>
  </tr>
" ;

// body of log listing
$oddeven = 'odd' ;
while( list( $lid , $uid , $ip , $agent , $mail_fromemail , $mail_to , $timestamp , $uname ) = $xoopsDB->fetchRow( $prs ) ) {
    $oddeven = ( $oddeven == 'odd' ? 'even' : 'odd' ) ;

    $ip = htmlspecialchars( $ip , ENT_QUOTES ) ;
    $mail_fromemail = htmlspecialchars( $mail_fromemail , ENT_QUOTES ) ;
    $mail_to = htmlspecialchars( $mail_to , ENT_QUOTES ) ;
    $uname = htmlspecialchars( ( $uid ? $uname : _GUESTS ) , ENT_QUOTES ) ;

    // make agent shorten
    if( preg_match( '/MSIE\s+([0-9.]+)/' , $agent , $regs ) ) {
        $agent_short = 'IE ' . $regs[1] ;
    } else if( stristr( $agent , 'Gecko' ) !== false ) {
        $agent_short = strrchr( $agent , ' ' ) ;
    } else {
        $agent_short = substr( $agent , 0 , strpos( $agent , ' ' ) ) ;
    }

    $agent4disp = htmlspecialchars( $agent , ENT_QUOTES ) ;
    $agent_desc = $agent == $agent_short ? $agent4disp : htmlspecialchars( $agent_short , ENT_QUOTES ) . "<img src='../images/dotdotdot.gif' alt='$agent4disp' title='$agent4disp' />" ;

    echo "
  <tr>
    <td class='$oddeven'><input type='checkbox' name='ids[]' value='$lid' /></td>
    <td class='$oddeven'>".formatTimestamp($timestamp)."</td>
    <td class='$oddeven'>$uname</td>
    <td class='$oddeven'>$ip<br />$agent_desc</td>
    <td class='$oddeven'>$mail_fromemail</td>
    <td class='$oddeven'>$mail_to</td>
  </tr>\n" ;
}

// footer of log listing
echo "
  <tr>
    <td colspan='6' align='left'>"._AM_LABEL_REMOVE."<input type='button' value='"._AM_BUTTON_REMOVE."' onclick='if(confirm(\""._AM_JS_REMOVECONFIRM."\")){document.MainForm.action.value=\"delete\"; submit();}' /></td>
  </tr>
</table>
</form>
</td></tr></table>
" ;
include "admin_footer.php";
