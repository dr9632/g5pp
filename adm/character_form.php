<?php
$sub_menu = "400100";
include_once('./_common.php');
include_once(G5_LIB_PATH.'/character.lib.php');

auth_check($auth[$sub_menu], 'w');

if ($w == '')
{
	$required_ch_name = 'required';
	$sound_only = '<strong class="sound_only">필수</strong>';

	$html_title = '추가';
}
else if ($w == 'u')
{
	$ch = get_character($ch_id);
	if (!$ch['ch_id'])
		alert('존재하지 않는 캐릭터 자료입니다.');

	$html_title = '수정';

	$ch['ch_name'] = get_text($ch['ch_name']);
    $ch['mb_id'] = get_text($ch['mb_id']);
    $ch['ch_thumb'] = get_text($ch['ch_thumb']);
    $ch['ch_head'] = get_text($ch['ch_head']);
    $ch['ch_body'] = get_text($ch['ch_body']);
}
else
	alert('제대로 된 값이 넘어오지 않았습니다.');

$g5['title'] .= '캐릭터 '.$html_title;
include_once('./admin.head.php');

// add_javascript('js 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_javascript(G5_POSTCODE_JS, 0);    //다음 주소 js
?>

<form name="fcharacter" id="fcharacter" action="./character_form_update.php" onsubmit="return fcharacter_submit(this);" method="post" enctype="multipart/form-data">
<input type="hidden" name="w" value="<?php echo $w ?>">
<input type="hidden" name="sfl" value="<?php echo $sfl ?>">
<input type="hidden" name="stx" value="<?php echo $stx ?>">
<input type="hidden" name="sst" value="<?php echo $sst ?>">
<input type="hidden" name="sod" value="<?php echo $sod ?>">
<input type="hidden" name="page" value="<?php echo $page ?>">
<input type="hidden" name="token" value="">
<input type="hidden" name="ch_id" value="<?php echo $ch_id ?>">

<div class="tbl_frm01 tbl_wrap">
	<table>
	<caption><?php echo $g5['title']; ?></caption>
	<colgroup>
		<col class="grid_4">
		<col>
		<col class="grid_4">
		<col>
	</colgroup>
	<tbody>
	<tr>
		<th scope="row"><label for="ch_name">캐릭터 이름<?php echo $sound_only ?></label></th>
		<td>
			<input type="text" name="ch_name" value="<?php echo $ch['ch_name'] ?>" id="ch_name" <?php echo $required_ch_name ?> class="frm_input <?php echo $required_ch_name_class ?>" size="15">
		</td>
		<th scope="row"><label for="mb_id">오너 아이디<?php echo $sound_only ?></label></th>
		<td><input type="text" name="mb_id" value="<?php echo $ch['mb_id'] ?>" id="mb_id" class="frm_input" size="15" maxlength="20"></td>
	</tr>
	<tr>
		<th scope="row"><label for="ch_thumb">두상</label></th>
		<td>
            <? if($ch['ch_thumb']) { ?>
                <img src="<?=$ch['ch_thumb']?>" class="character-thumb">
			<? } else { ?>
				이미지 미등록
			<? } ?>
		</td>
        <td colspan="2">
            <input type="file" name="ch_thumb_file" />
            <input type="hidden" name="ch_thumb" value="<?php echo $ch['ch_thumb'] ?>" />
		</td>
	</tr>
    <tr>
		<th scope="row"><label for="ch_head">흉상</label></th>
		<td>
            <? if($ch['ch_head']) { ?>
                <img src="<?=$ch['ch_head']?>" class="character-thumb">
			<? } else { ?>
				이미지 미등록
			<? } ?>
		</td>
        <td colspan="2">
            <input type="file" name="ch_head_file" />
            <input type="hidden" name="ch_head" value="<?php echo $ch['ch_head'] ?>" />
		</td>
	</tr>
    <tr>
		<th scope="row"><label for="ch_body">전신</label></th>
		<td>
            <? if($ch['ch_body']) { ?>
                <img src="<?=$ch['ch_body']?>" class="character-thumb">
			<? } else { ?>
				이미지 미등록
			<? } ?>
		</td>
        <td colspan="2">
            <input type="file" name="ch_body_file" />
            <input type="hidden" name="ch_body" value="<?php echo $ch['ch_body'] ?>" />
		</td>
	</tr>
	</tbody>
	</table>
</div>

<div class="btn_confirm01 btn_confirm">
	<input type="submit" value="확인" class="btn_submit" accesskey='s'>
	<a href="./character_list.php?<?php echo $qstr ?>">목록</a>
</div>
</form>

<script>
function fcharacter_submit(f)
{
	return true;
}
</script>

<?php
include_once('./admin.tail.php');
?>