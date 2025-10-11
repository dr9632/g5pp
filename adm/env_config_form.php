<?php
$sub_menu = "100110";
require_once './_common.php';

auth_check_menu($auth, $sub_menu, 'r');

if ($is_admin != 'super') {
    alert('최고관리자만 접근 가능합니다.');
}

// https://github.com/gnuboard/gnuboard5/issues/296 이슈처리
$sql = " select * from {$g5['config_table']} limit 1";
$config = sql_fetch($sql);

$g5['title'] = '사이트 환경설정';
require_once './admin.head.php';

$pg_anchor = '<ul class="anchor">
    <li><a href="#anc_cf_basic">기본환경</a></li>
</ul>';

?>

<form name="fenvconfigform" id="fenvconfigform" method="post" onsubmit="return fenvconfigform_submit(this);">
    <input type="hidden" name="token" value="" id="token">

    <section id="anc_cf_basic">
        <h2 class="h2_frm">홈페이지 부가환경 설정</h2>
        <?php echo $pg_anchor ?>

        <div class="tbl_frm01 tbl_wrap">
            <table>
                <caption>홈페이지 부가환경 설정</caption>
                <colgroup>
                    <col class="grid_4">
                    <col>
                    <col class="grid_4">
                    <col>
                </colgroup>
                <tbody>
                    <tr>
                        <th scope="row"><label for="cf_title">홈페이지 제목<strong class="sound_only">필수</strong></label></th>
                        <td><input type="text" name="cf_title" value="<?php echo get_sanitize_input($config['cf_title']); ?>" id="cf_title" required class="required frm_input" size="40"></td>
                        <th scope="row"><label for="cf_public_config">공개 설정</label></th>
                        <td>
                            <input type="checkbox" name="cf_public" value="1" id="cf_public" <?php echo $config['cf_public']?'checked':''; ?>>
				            <label for="cf_public">사이트공개</label>
                            &nbsp;&nbsp;
                            <input type="checkbox" name="cf_open_register" value="1" id="cf_open_register" <?php echo $config['cf_open_register']?'checked':''; ?>>
                            <label for="cf_open_register">계정생성 가능</label>
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="cf_bgm">배경음악</label></th>
                        <td colspan="3">
                            <?php echo help('유튜브 재생목록 아이디 (https://www.youtube.com/watch?list=재생목록고유아이디) 를 입력해 주세요.') ?>
                            <input type="text" name="cf_bgm" value="<?php echo $config['cf_bgm']; ?>" id="cf_bgm" class="frm_input" size="80">
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>

    <div class="btn_fixed_top btn_confirm">
        <input type="submit" value="확인" class="btn_submit btn" accesskey="s">
    </div>

</form>

<script>
    // 각 요소의 초기값 저장
    var initialValues = {
        cf_admin: $('#cf_admin').val(),
        cf_analytics: $('#cf_analytics').val(),
        cf_add_meta: $('#cf_add_meta').val(),
        cf_add_script: $('#cf_add_script').val()
    };

    function fenvconfigform_submit(f) {
        f.action = "./env_config_form_update.php";
        return true;
    }
</script>

<?php
if (stripos($config['cf_image_extension'], "webp") !== false) {
    if (!function_exists("imagewebp")) {
        echo '<script>' . PHP_EOL;
        echo 'alert("이 서버는 webp 이미지를 지원하고 있지 않습니다.\n이미지 업로드 확장자에서 webp 확장자를 제거해 주십시오.\n제거하지 않으면 이미지와 관련된 오류가 발생할 수 있습니다.");' . PHP_EOL;
        echo 'document.getElementById("cf_image_extension").focus();' . PHP_EOL;
        echo '</script>' . PHP_EOL;
    }
}

require_once './admin.tail.php';
