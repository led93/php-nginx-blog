<?php

$root = realpath(__DIR__);
$sql = file_get_contents($root . '/data/init.sql');

if($sql === false)
{
    $error = 'Cannot find SQL file';
}

if(!$error)
{
    $pdo = new PDO('mysql:dbname=tutorial;host=mysql', 'tutorial', 'secret', [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
    $result = $pdo->exec($sql);
    if($result === false)
    {
        $error = 'Could not run SQL: ' . print_r($pdo->errorInfo(), true);
    }
}

$count = null;
if(!$error)
{
    $sql = "SELECT COUNT(*) AS c FROM post";
    $stmt = $pdo->query($sql);
    if($stmt)
    {
        $count = $stmt->fetchColumn();
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog installer</title>
    <style type="text/css">
        .box {
            border: 1px dotted silver;
            border-radius: 5px;
            padding: 4px;
        }
        .error {
            background-color: #ff6666;
        }
        .success {
            background-color: #88ff88;
        }
    </style>
</head>
<body>
    <?php if($error): ?>
        <div class="error box">
            <?php echo $error ?>
        </div>
    <?php else: ?>
        <div class="success box">
            The database and demo data was created OK.
            <?php if($count): ?>
                <?php echo $count ?> new rows were created.
            <?php endif?>
        </div>
    <?php endif ?>
</body>
</html>