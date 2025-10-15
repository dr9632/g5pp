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

function get_mem_character($mb_id)
{
	global $g5;
	$character = sql_fetch("select * from {$g5['character_table']} where mb_id = '{$mb_id}'");
	
	return $character;
}

// 캐릭터 목록 가져오기
// 변수 지정되지 않았을 시 전체를 불러옴)
function get_character_list($mb_id='') {
	global $g5;

	$character = array();

	$sql_common = "select *
			from	{$g5['character_table']}";
	if($mb_id)
		$sql_common .= " where mb_id = '{$mb_id}'";
	$sql_common .= " order by ch_id asc";

	$result = sql_query($sql_common);

	for($i=0; $row=sql_fetch_array($result); $i++) {
		$character[] = $row;
	}

	return $character;
}
?>