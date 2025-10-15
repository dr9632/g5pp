<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/character.lib.php');
include_once(G5_LIB_PATH.'/character_line.lib.php');

if (!$is_member)
    goto_url(G5_BBS_URL."/login.php?url=".urlencode(G5_BBS_URL."/mypage.php"));

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/character.php');
    return;
}

// 테마에 character.php 있으면 include
if(defined('G5_THEME_PATH')) {
    $theme_mypage_file = G5_THEME_PATH.'/character.php';
    if(is_file($theme_mypage_file)) {
        include_once($theme_mypage_file);
        return;
        unset($theme_mypage_file);
    }
}

$g5['title'] =  $member['mb_name'].' 캐릭터 목록';

$mych_array = get_character_list($member['mb_id']);

// 캐릭터 선택 후 넘어온 페이지라면 다음 처리
if(isset($_GET['ch_id'])) {
    $view_ch = get_character($_GET['ch_id']);
    if($view_ch['mb_id'] != $member['mb_id'])
        alert('올바르지 않은 경로입니다.');
    $view_cl = get_character_line($_GET['ch_id']);
}

include_once('./_head.php');
?>

<!-- 마이페이지 시작 { -->
<div id="smb_my" class="not_main">
    <!-- 캐릭터 조회 시작 { -->
    <section id="smb_my_ov">
        <h2>캐릭터 목록</h2>
        <div id="smb_my_act">
            <ul>
                <?php if ($is_admin == 'super') { ?><li><a href="<?php echo G5_ADMIN_URL; ?>/" class="btn_admin">관리자</a></li><?php } ?>
                <li><a href="<?php echo G5_BBS_URL; ?>/mypage.php" class="btn01">마이페이지</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=register_form.php" class="btn01">회원정보수정</a></li>
                <li><a href="<?php echo G5_BBS_URL; ?>/member_confirm.php?url=member_leave.php" onclick="return member_leave();" class="btn01">회원탈퇴</a></li>
            </ul>
        </div>

        <dl class="op_area">
            <div class="char_option">
                <form name="frm_view_character" action="<?php echo G5_BBS_URL. '/character.php?'?>" method="get">
                    <select name="ch_id" id="ch_id" class="char_dropdown_list">
                        <option value="">캐릭터 선택</option>
                        <?	for($i = 0; $i < count($mych_array); $i++) { $ch = $mych_array[$i]; ?>
                            <option value="<?=$ch['ch_id']?>" <?=$view_ch['ch_id'] == $ch['ch_id'] ? "selected" : ""?>>
                                <?=$ch['ch_name']?>
                            </option>
                    <? } ?>
                    </select>            
                    <input type="submit" value="조회" class="char_btn"/>
                    <a href="./character.php?w=a" class="btn btn_01" style="padding:0px 6px; height:24px; line-height:23px">캐릭터 추가</a>
                </form>
            </div>
        </dl>
    <!-- 캐릭터 조회 끝 -->

    <!-- 캐릭터 상세 정보 시작 { -->
    <section id="smb_my_wish">
        <?php if(!($_GET['ch_id']) && !($_GET['w'] == 'a')) { ?>
            <ul>
                <li class="empty_li">조회할 캐릭터를 선택해주세요.</li>
            </ul>
        <?php } elseif($_GET['w'] == 'a') { ?>
            <div class="list_02">
                <form name="fcharacter" id="fcharacter" action="./character_update.php" onsubmit="return fcharacter_submit(this);" method="post" enctype="multipart/form-data">
                <input type="hidden" name="w" value="a">
                <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
                <input type="hidden" name="ch_id" value="<?php echo $ch_id ?>">
                <div class="tbl_frm01 tbl_wrap">
                    <table>
                    <colgroup>
                        <col class="grid_4">
                        <col>
                        <col class="grid_4">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row"><label for="ch_name">캐릭터 이름<?php echo $sound_only ?></label></th>
                        <td colspan="3">
                            <input type="text" name="ch_name" value="<?php echo $view_ch['ch_name'] ?>" id="ch_name" <?php echo $required_ch_name ?> class="frm_input <?php echo $required_ch_name_class ?>" size="15">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ch_thumb">두상</label></th>
                        <td colspan="3">
                            <input type="file" name="ch_thumb_file" />
                            <input type="hidden" name="ch_thumb" value="<?php echo $ch['ch_thumb'] ?>" />
                            <? if($view_ch['ch_thumb']) { ?>
                                <a href="<?=$view_ch['ch_thumb']?>" class="ui-btn" target="_blank">이미지 확인</a>
                            <? } ?>
                        </td>                        
                    </tr>
                    <tr>
                        <th scope="row"><label for="ch_head">흉상</label></th>
                        <td colspan="3">
                            <input type="file" name="ch_head_file" />
                            <input type="hidden" name="ch_head" value="<?php echo $view_ch['ch_head'] ?>" />
                            <? if($view_ch['ch_head']) { ?>
                                <a href="<?=$view_ch['ch_head']?>" class="ui-btn" target="_blank">이미지 확인</a>
                            <? } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ch_body">전신</label></th>
                        <td colspan="3">
                            <input type="file" name="ch_body_file" />
                            <input type="hidden" name="ch_body" value="<?php echo $view_ch['ch_body'] ?>" />
                            <? if($view_ch['ch_body']) { ?>
                                <a href="<?=$view_ch['ch_body']?>" class="ui-btn" target="_blank">이미지 확인</a>
                            <? } ?>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                </div>

                <div class="btn_confirm01 btn_confirm">
                    <input type="submit" value="확인" class="btn_submit" accesskey='s'>
                </div>
                </form>
            </div>
        <?php } else { ?>
            <div class="list_02">
                <form name="fcharacter" id="fcharacter" action="./character_update.php" onsubmit="return fcharacter_submit(this);" method="post" enctype="multipart/form-data">
                <input type="hidden" name="w" value="u">
                <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
                <input type="hidden" name="ch_id" value="<?php echo $ch_id ?>">
                <div class="tbl_frm01 tbl_wrap">
                    <table>
                    <colgroup>
                        <col class="grid_4">
                        <col>
                        <col class="grid_4">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row"><label for="ch_name">캐릭터 이름<?php echo $sound_only ?></label></th>
                        <td colspan="3">
                            <input type="text" name="ch_name" value="<?php echo $view_ch['ch_name'] ?>" id="ch_name" <?php echo $required_ch_name ?> class="frm_input <?php echo $required_ch_name_class ?>" size="15">
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ch_thumb">두상</label></th>
                        <td colspan="3">
                            <input type="file" name="ch_thumb_file" />
                            <input type="hidden" name="ch_thumb" value="<?php echo $ch['ch_thumb'] ?>" />
                            <? if($view_ch['ch_thumb']) { ?>
                                <a href="<?=$view_ch['ch_thumb']?>" class="ui-btn" target="_blank">이미지 확인</a>
                            <? } ?>
                        </td>                        
                    </tr>
                    <tr>
                        <th scope="row"><label for="ch_head">흉상</label></th>
                        <td colspan="3">
                            <input type="file" name="ch_head_file" />
                            <input type="hidden" name="ch_head" value="<?php echo $view_ch['ch_head'] ?>" />
                            <? if($view_ch['ch_head']) { ?>
                                <a href="<?=$view_ch['ch_head']?>" class="ui-btn" target="_blank">이미지 확인</a>
                            <? } ?>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ch_body">전신</label></th>
                        <td colspan="3">
                            <input type="file" name="ch_body_file" />
                            <input type="hidden" name="ch_body" value="<?php echo $view_ch['ch_body'] ?>" />
                            <? if($view_ch['ch_body']) { ?>
                                <a href="<?=$view_ch['ch_body']?>" class="ui-btn" target="_blank">이미지 확인</a>
                            <? } ?>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                </div>

                <div class="btn_confirm01 btn_confirm">
                    <input type="submit" value="확인" class="btn_submit" accesskey='s'>
                </div>
                </form>

                <form name="fcharacterline" id="fcharacterline" action="./character_line_update.php" onsubmit="return fcharacter_line_submit(this);" method="post" enctype="multipart/form-data">
                <input type="hidden" name="w" value="c">
                <input type="hidden" name="mb_id" value="<?php echo $member['mb_id'] ?>">
                <input type="hidden" name="ch_id" value="<?php echo $ch_id ?>">
                <div class="tbl_frm01 tbl_wrap">
                    <table>
                    <caption>대사 목록</caption>
                    <colgroup>
                        <col class="grid_4">
                        <col>
                        <col class="grid_4">
                        <col>
                    </colgroup>
                    <tbody>
                    <tr>
                        <th scope="row"><label for="cl_text">신규 등록</label></th>
                        <td colspan="3">
                            <input type="text" name="cl_text" id="cl_text" class="frm_input" size="120">&nbsp;&nbsp;<input type="submit" value="추가" class="btn_submit" style="padding: 8px 12px; border: 0px;" accesskey='s'>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="ch_head">등록 목록</label></th>
                        <td colspan="3">
                            <? if(isset($view_cl)) {
                                for($i=0; $le=$view_cl[$i];$i++){
                                    $one_update = '<a href="./character_line_update.php?w=u&amp;cl_id=' . $le['cl_id'] . '&amp;' . $qstr . '" class="btn btn_01" style="padding:0px 6px; height:24px; line-height:23px">수정</a>';
                                    $one_delete = '<a href="./character_line_update.php?w=cd&cl_id=' . $le['cl_id'] . '&amp;ch_id=' . $le['ch_id'] . '&amp;mb_id=' . $member['mb_id'] . '" class="btn btn_01" style="padding:0px 6px; height:24px; line-height:23px">삭제</a>';
                                    echo $one_delete." ".$le['cl_text']."<br/>";
                                }
                            } else {?>
                                등록된 대사가 없습니다.
                            <? } ?>
                        </td>
                    </tr>
                    </tbody>
                    </table>
                </div>

                <div class="btn_confirm01 btn_confirm">
                    <a href="./character_list.php?<?php echo $qstr ?>">목록</a>
                </div>
                </form>
            </div>
            <?php } ?>
    </section>
    <!-- } 최근 호출 내역 끝 -->
</div>

<script>
function fcharacter_submit(f)
{
	return true;
}

function member_leave()
{
    return confirm('정말 회원에서 탈퇴 하시겠습니까?')
}
</script>
<!-- } 마이페이지 끝 -->

<?php
include_once("./_tail.php");