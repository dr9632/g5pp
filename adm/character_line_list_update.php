<?php
$sub_menu = "400200";
require_once './_common.php';
include_once(G5_LIB_PATH.'/character.lib.php');

check_demo();
auth_check_menu($auth, $sub_menu, "w");
check_admin_token();

$act_button     = isset($_POST['act_button']) ? strip_tags($_POST['act_button']) : '';
$character_table    = (isset($_POST['character_table']) && is_array($_POST['character_table'])) ? $_POST['character_table'] : array();

if (!(isset($_POST['install']) && $_POST['install'] == 1)) {
    // install 값이 넘어오지 않을 경우 미설치 상태
    // 테이블 설치 진행
    if(!sql_query(" DESCRIBE dr_charline ", false)) {
           $sql_query = sql_query(" CREATE TABLE IF NOT EXISTS `dr_charline` (
            `cl_id` int(11) NOT NULL auto_increment,
            `ch_id` int(11) NOT NULL default '0',
            `cl_text` text NOT NULL,
            PRIMARY KEY  (`cl_id`)
          ) ENGINE=MyISAM DEFAULT CHARSET=utf8 ", true);
    }
}

goto_url('./character_line_list.php');
