<?php
$text = "";
$post = "";
$id = "";
//バリデーション
//送信されたら代入
if (isset($_POST['send']) === true) {
    $text = $_POST["text"];
    $post = $_POST["post"];
    $id = uniqid();
    if (empty($text)) {
        echo "記入してください";
    }
    /**ファイル書き込み */
    $fp = fopen("fwrite.csv", "a");
    fwrite($fp, $id . "," . $text . "," . $post . "\n");
    fclose($fp);
};
/**ファイル読み込み */
$fp = fopen("fwrite.csv", "r");

$post_array = [];
//連想配列に変換
while ($line = fgets($fp)) {
    $temp = explode(",", $line);
    $temp_array = [
        "id" => $temp[0],
        "text" => $temp[1],
        "post" => $temp[2],

    ];
    $post_array[] = $temp_array;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>newsへようこそ</title>
</head>

<body>
    <form action="" method="post">
        <div>
            <p>投稿</p>
            <input type="text" name="text">
        </div>
        <div>
            <p>投稿</p>
            <input type="textarea" name="post">
        </div>
        <div>
            <input type="submit" name="send" value="送信" onsubmit="return dialog()">
        </div>
    </form>
    <ul>
        <?php foreach ($post_array as $data) : ?>
            <?= "<li>" ?>
            <?= $data["text"] . ":" . $data["post"]; ?>
            <a href="comment.php?id=<?= $data["id"] ?>" name="page_change">詳細ページ・コメントへ</a>
            <?= "</li>" ?>
        <?php endforeach; ?>
    </ul>
</body>

</html>