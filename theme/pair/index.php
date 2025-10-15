<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<div class="main_visual">
    <div class="char_layer<?php echo $is_member && $member['ch_id'] ? "" : " loader_layer" ?>">
        <?php if ($is_member && $member['ch_id']) { ?>
            <img src="<?php echo $ch['ch_body'] ?>"/>
        <?php } else { ?>
            <div class="loader"></div><br>
            로그인하거나 메인페이지 캐릭터를 설정해주세요.
        <? } ?>
    </div>
    <?php if ($is_member && $member['ch_id'] && get_character_line_cnt($ch['ch_id'])>0) { ?>
    <div class="char_line">
        <p>
            <?php echo get_rand_character_line($ch['ch_id']) ?>
        </p>
    </div>
    <?php } ?>    
</div>
<div class="main_contents">
    <h2 class="sound_only">최신글</h2>
    <div class="latest_wr">
    <!-- 최신글 시작 { -->
        <?php
        echo latest_all('theme/new_contents','전체게시판',10,24,array('notice'));
        ?>
    <!-- } 최신글 끝 -->
    </div>
</div>

<?php if ($is_member) { ?>
<div class="main_select_char">
    <div class="char_option">
        <form name="frm_main_character" action="<? echo G5_THEME_URL.'/maincharacter_update.php' ?>" method="post">
            <input type="hidden" name="mb_id" value="<?=$member['mb_id']?>" />
            <input type="hidden" name="url" value="<?php echo $_SERVER['HTTP_REFERER']; ?>">
            <select name="ch_id" id="ch_id" class="char_dropdown_list">
                <option value="">메인캐릭터 선택</option>
                <?	for($i = 0; $i < count($ch_array); $i++) { $ch = $ch_array[$i]; ?>
                    <option value="<?=$ch['ch_id']?>" <?=$member['ch_id'] == $ch['ch_id'] ? "selected" : ""?>>
                    <?=$ch['ch_name']?>
                </option>
            <? } ?>
            </select>            
			<input type="submit" value="변경" class="char_btn"/>
        </form>
    </div>
</div>
<?php } ?>

<?php
include_once(G5_THEME_PATH.'/tail.php');