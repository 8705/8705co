<?php

ini_set("mbstring.internal_encoding","UTF-8");

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    echo "不正なアクセスです。";
    exit;
} else {

    require('Validation.php');
    $Validation = new Validation;

    $post = $_POST;

    // $errors = $Validation->validate($post);
$errors = 0;

    if (!$errors) {
        // mb_send_mailのエンコードを設定する。uniはutf-8。
        mb_language("uni");

        $to      = "shungo.ishino@gmail.com";
        $header  = "From: ".$post['email'];
        $subject = '【8705】お問い合わせ';
        $message = $post["name"]."様より、\r\n\r\n"
                  ."8705のサイトからお問い合わせがありました。\r\n"
                  ."\r\n"
                  ."◯お問い合わせ内容\r\n"
                  .$post["message"];

        if (mb_send_mail($to, $subject, $message, $header)) {
            header("Location: http://8705.co/thanks.html");
            exit;
        } else {
            echo "メールの送信に失敗しました。";
            exit;
        }
    } else {
echo "むりっす。";
exit;
    }
}
