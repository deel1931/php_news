<?php
$id = $_GET["id"];

/**ファイル読み込み */
$fp = fopen("fwrite.csv", "r");

$post_array = [];
while ($line = fgets($fp)) {
    $temp = explode(",", $line);
    $temp_array = [
        "id" => $temp[0],
        "text" => $temp[1],
        "post" => $temp[2],

    ];
    $post_array[] = $temp_array;
}

//idのインデント取得
$get_id = array_column($post_array, "id");
//持ってきたIDと一致する要素番号を取得
$get_line = array_search($id, $get_id);
//ファイル読み込み
$file = file("fwrite.csv");
//IDと一致する行取得s
$get_text = $file[$get_line];
$division = explode(",", $get_text);

//コメント投稿
$comment = "";
$comment_id = "";
$commentId = "";
if (isset($_POST['send']) === true) {
    $comment = $_POST["comment"];
    $comment_id = $_POST["id"];
    $commentId = uniqid();
    $fp = fopen("comment.csv", "a");
    fwrite($fp, $comment_id  . "," . $commentId . "," . $comment . "\n");
}
//コメント取得
/**ファイル読み込み */
$fp = fopen("comment.csv", "r");

$comment_array = [];
//連想配列に変換
while ($line = fgets($fp)) {
    $temp = explode(",", $line);
    $temp_array = [
        "id" => $temp[0],
        "commentId" => $temp[1],
        "comment" => $temp[2]
    ];
    $comment_array[] = $temp_array;
}
//ファイル全部読み込み
$comment_file = file("comment.csv");
//comment_idとIDが一致するものを見つける
$get_comment = array_column($comment_array, "id");
$get_commentId = array_keys($get_comment, $id);

//コメント削除 
if (isset($_POST["delete"]) === true) {
    $deleteId = $_POST["delete_id"];
    $delete_comment = array_column($comment_array, "commentId");
    $delete_commentId = array_search($deleteId, $delete_comment);
    $delete_file = file('comment.csv');
    unset($delete_file[$delete_commentId]);
    file_put_contents('comment.csv', $delete_file);

    /**ファイル読み込み */
    $fp = fopen("comment.csv", "r");

    $comment_array = [];
    //連想配列に変換
    while ($line = fgets($fp)) {
        $temp = explode(",", $line);
        $temp_array = [
            "id" => $temp[0],
            "commentId" => $temp[1],
            "comment" => $temp[2]
        ];
        $comment_array[] = $temp_array;
    }
    //ファイル全部読み込み
    $comment_file = file("comment.csv");
    //comment_idとIDが一致するものを見つける
    $get_comment = array_column($comment_array, "id");
    $get_commentId = array_keys($get_comment, $id);
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>詳細ページ</title>
</head>

<body>
    <h1>記事の詳細へようこそ</h1>
    <a href="index.php">HOME</a><br>
    <!--投稿したものの詳細表示-->
    <?php
    echo $division[1];
    ?>
    <br>
    <?php
    echo $division[2];
    ?>
    <br>
    <!--コメント-->
    <form action="" method="post">
        <p>コメント投稿</p>
        <input type="hidden" name="id" value="<?= $id ?>">
        <input type="text" name="comment"><br>
        <input type="submit" name="send" value="送信"><br>
    </form>
    <h2>コメント一覧</h2>
    <?php
    foreach ($get_commentId as $data) : ?>
        <?php $comment_file[$data];
        $comment_division = explode(",", $comment_file[$data]); ?>
        <?= $comment_division[2]; ?>
        <form action="" method="post">
            <input type="hidden" name="delete_id" value="<?= $comment_division[1] ?>">
            <input type="submit" name="delete" value="削除">
        </form>
        <br>
    <?php endforeach; ?>
</body>

</html>