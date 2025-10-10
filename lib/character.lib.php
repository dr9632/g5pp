<?php
if (!defined('_GNUBOARD_')) exit;

/*************************************************************************
**
**  캐릭터 관련 함수 모음
**
*************************************************************************/

// 캐릭터 정보 추출
function get_character($ch_id)
{
    global $g5;

    $sql = " SELECT * from {$g5['character_table']} where ch_id = $ch_id and ch_state != '삭제'");
    $row = sql_fetch($sql, false);

    return $row
}