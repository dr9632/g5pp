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
    <div class="char_layer">
        <img src="<? echo G5_THEME_IMG_URL.'/1207(1).png' ?>"/>
    </div> 
    <div class="char_line">
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras sed consequat lorem, sed eleifend elit. Mauris nisl nulla, iaculis id tristique sit amet, volutpat suscipit urna. Etiam egestas aliquet tincidunt. Curabitur ac venenatis velit. Praesent blandit id nulla ut ullamcorper. Suspendisse potenti. Quisque suscipit venenatis odio lacinia tempor. Suspendisse tincidunt arcu vitae magna pulvinar viverra ut at sem. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Vivamus scelerisque et ipsum nec mollis. Fusce elit neque, aliquet ut tortor in, iaculis rhoncus leo. Mauris tempor lectus convallis purus commodo fringilla.</p>
    </div>
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

<div class="main_select_char">
    <div class="char_option">
        <select name="ch_id" id="ch_id" class="char_dropdown_list">
			<option value="">메인캐릭터 선택</option>
            <?	for($i = 0; $i < count($ch_array); $i++) { $ch = $ch_array[$i]; ?>
			    <option value="<?=$ch['ch_id']?>" <?=$member['ch_id'] == $ch['ch_id'] ? "selected" : ""?>>
				<?=$ch['ch_name']?>
			</option>
		<? } ?>
        </select>
    </div>
</div>

<?php
include_once(G5_THEME_PATH.'/tail.php');