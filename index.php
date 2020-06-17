<html>
<head>
    <title>掲示板</title>
    <link rel="stylesheet" href="css.css">
</head>
<body style="background-color: black;">
<h1 style="background-color: green;">
   掲示板App
    
</h1>

<h2 style="text-align: center; background-color: aqua;">投稿フォーム</h2>

<form method="POST" action="<?php print($_SERVER['PHP_SELF']) ?>" style="background-color: greenyellow;">
    <input class="fo" type="text" name="personal_name" placeholder="名前" require style="width: 100%;"><br><br>
    <textarea name="contents" rows="8" cols="40" placeholder="内容" required style="width: 100%;">
</textarea><br><br>
<div style="text-align: center;">
    <input type="submit" name="btn" value="投稿する"style="background-color: red; text-align:center;"></input>
</div>
</form>

<h2 style="background-color: orange; text-align: center;">スレッド</h2>

<form method="post" action="delete.php" style="background-color: pink; text-align: center;">
    <button type="submit" style="background-color: blue; color: white;">投稿を全削除する</button>
</form>

<?php

const THREAD_FILE = 'thread.txt';

function readData() {
    // ファイルが存在しなければデフォルト空文字のファイルを作成する
    if (! file_exists(THREAD_FILE)) {
        $fp = fopen(THREAD_FILE, 'w');
        fwrite($fp, '');
        fclose($fp);
    }

    $thread_text = file_get_contents(THREAD_FILE);
    echo $thread_text;
}

function writeData() {
    $personal_name = $_POST['personal_name'];
    $contents = $_POST['contents'];
    $contents = nl2br($contents);

    $data = "<hr>\n";
    $data = $data."<p>投稿者:".$personal_name."</p>\n";
    $data = $data."<p>内容:</p>\n";
    $data = $data."<p>".$contents."</p>\n";

    $fp = fopen(THREAD_FILE, 'a');

    if ($fp){
        if (flock($fp, LOCK_EX)){
            if (fwrite($fp,  $data) === FALSE){
                print('ファイル書き込みに失敗しました');
            }

            flock($fp, LOCK_UN);
        }else{
            print('ファイルロックに失敗しました');
        }
    }

    fclose($fp);

    // ブラウザのリロード対策
    $redirect_url = $_SERVER['HTTP_REFERER'];
    header("Location: $redirect_url");
    exit;
    //nyande?

}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    writeData();
}

readData();

?>

<style>
h1{
    text-align:center;
}

p{
    background-color: gray;
    color: gold;
}

input{
    text-align: center;
}

textarea{
    background-color: tomato;
    color: white;
}
</style>

</body>
</html>