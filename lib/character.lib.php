<?php
if (!defined('_GNUBOARD_')) exit;

/*************************************************************************
**
**  캐릭터 관련 함수 모음
**
*************************************************************************/

// 캐릭터 기본 정보 가져오기
function get_character($ch_id)
{
	global $g5;
	$character = sql_fetch("select * from {$g5['character_table']} where ch_id = '{$ch_id}'");
	
	return $character;
}
