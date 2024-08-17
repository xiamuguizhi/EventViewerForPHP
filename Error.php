<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>错误日志查看器</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            background-color: #f4f4f4;
        }
        h1 {
            color: #333;
        }
        .log-container {
            background-color: #fff;
            border: 1px solid #ccc;
            padding: 15px;
            max-height: 600px;
            overflow-y: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .log-line {
            border-bottom: 1px solid #eee;
            padding: 5px 0;
            font-size: 14px;
            color: #555;
        }
        .log-line:last-child {
            border-bottom: none;
        }
        .error-count {
            color: #d9534f;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .no-log {
            color: #d9534f;
            font-weight: bold;
        }
        .password-form {
            margin-bottom: 20px;
        }
        .password-input {
            padding: 8px;
            font-size: 14px;
            width: 200px;
            margin-right: 10px;
        }
        .submit-button {
            padding: 8px 12px;
            font-size: 14px;
            background-color: #5cb85c;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        .submit-button:hover {
            background-color: #4cae4c;
        }
        .error-message {
            color: #d9534f;
            font-weight: bold;
        }
    </style>
</head>
<body>

<h1>错误日志查看器</h1>

<?php
// 硬编码的密码
$correctPassword = 'admin'; //默认密码
$showLogs = false;
$errorMessage = '';

// 处理表单提交
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputPassword = $_POST['password'] ?? '';
    if ($inputPassword === $correctPassword) {
        $showLogs = true;
    } else {
        $errorMessage = '密码错误，请重试。';
    }
}

if ($showLogs) {
    // 定义日志文件路径
    $logFile = __DIR__ . '/error.log';

    // 检查日志文件是否存在
    if (file_exists($logFile)) {
        // 读取日志文件内容
        $logContent = file($logFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        // 获取日志条数
        $logCount = count($logContent);

        // 输出日志条数
        echo "<p class='error-count'>日志总条数: $logCount</p>";

        // 输出日志内容
        echo "<div class='log-container'>";
        foreach ($logContent as $line) {
            echo "<div class='log-line'>" . htmlspecialchars($line) . "</div>";
        }
        echo "</div>";
    } else {
        echo "<p class='no-log'>error.log 文件不存在。</p>";
    }
} else {
    // 显示密码输入表单
    echo "<form method='post' class='password-form'>";
    echo "<input type='password' name='password' class='password-input' placeholder='请输入密码' required>";
    echo "<button type='submit' class='submit-button'>查看日志</button>";
    echo "</form>";

    // 显示错误信息（如果有）
    if ($errorMessage) {
        echo "<p class='error-message'>$errorMessage</p>";
    }
}
?>

</body>
</html>
