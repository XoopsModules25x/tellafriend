<?php
// $Id: xoops_version.php,v 1.5 2003/02/12 11:36:33 okazu Exp $
//  ------------------------------------------------------------------------ //
//                XOOPS - PHP Content Management System                      //
//                    Copyright (c) 2000 XOOPS.org                           //
//                       <http://www.xoops.org/>                             //
//  ------------------------------------------------------------------------ //
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
if (!defined('XOOPS_ROOT_PATH')) {
    die('XOOPS root path not defined');
}
$modversion['name']                = _MI_TELLAFRIEND_MODNAME;
$modversion['version']             = 1.06;
$modversion['description']         = _MI_TELLAFRIEND_MODDESC;
$modversion['credits']             = "PEAK Corp. http://www.peak.ne.jp/";
$modversion['author']              = "GIJOE";
$modversion['help']                = 'page=help';
$modversion['license']             = 'GNU GPL 2.0 or later';
$modversion['license_url']         = "www.gnu.org/licenses/gpl-2.0.html";
$modversion['official']            = 0;
$modversion['image']               = "images/tellafriend_slogo.png";
$modversion['dirname']             = "tellafriend";

$modversion['dirmoduleadmin']      = '/Frameworks/moduleclasses/moduleadmin';
$modversion['icons16']             = '../../Frameworks/moduleclasses/icons/16';
$modversion['icons32']             = '../../Frameworks/moduleclasses/icons/32';
$modversion['release_date']        = '2013/04/26';
$modversion["module_website_url"]  = "www.xoops.org";
$modversion["module_website_name"] = "XOOPS";
$modversion["module_status"]       = "Final";
$modversion['min_php']             = '5.2';
$modversion['min_xoops']           = "2.5.6";
$modversion['min_admin']           = '1.1';
$modversion['min_db']              = array(
    'mysql'  => '5.0.7',
    'mysqli' => '5.0.7'
);

// Sql file
$modversion['sqlfile']['mysql'] = "sql/mysql.sql";

// Tables created by sql file
$modversion['tables'][0] = "tellafriend_log";

//Admin things
$modversion['hasAdmin'] = 1;
$modversion['system_menu'] = 1;
$modversion['adminindex'] = "admin/index.php";
$modversion['adminmenu'] = "admin/menu.php";

// Menu
$modversion['hasMain'] = 1;

// Config Settings
$modversion['hasconfig'] = 1;

$modversion['config'][1] = array(
    'name'            => 'max4guest' ,
    'title'            => '_MI_TELLAFRIEND_MAX4GUEST' ,
    'description'    => '' ,
    'formtype'        => 'textbox' ,
    'valuetype'        => 'int' ,
    'default'        => '5' ,
    'options'        => array()
) ;

$modversion['config'][] = array(
    'name'            => 'max4user' ,
    'title'            => '_MI_TELLAFRIEND_MAX4USER' ,
    'description'    => '' ,
    'formtype'        => 'textbox' ,
    'valuetype'        => 'int' ,
    'default'        => '10' ,
    'options'        => array()
) ;

$modversion['config'][] = array(
    'name'            => 'can_bodyedit' ,
    'title'            => '_MI_TELLAFRIEND_BODYEDIT' ,
    'description'    => '' ,
    'formtype'        => 'yesno' ,
    'valuetype'        => 'int' ,
    'default'        => true ,
    'options'        => array()
) ;

// Templates
$modversion['templates'][1]['file'] = 'tellafriend_form.html';
$modversion['templates'][1]['description'] = 'Tell a Friend Form';
