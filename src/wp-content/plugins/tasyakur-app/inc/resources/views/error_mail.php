<html>
<head>
    <style>
        body {
            width: auto;
            height: auto;
        }
    </style>
</head>
<body>
    <h3>Hi there!</h3>
    <p>Our system just caught an unexpected exception was triggered with following information:</p>
    <?php
    if (isset($data['requestUrl'])) {
        ?>
    <p>
        Request URL: <a href="<?=$data['requestUrl']?>"><?=$data['requestUrl']?></a>
    </p>
    <?php
    }
    ?>
    <p>
        Code: <?=$data['code'] ?? ''?>
    </p>
    <p>
        Message: <?=$data['message'] ?? ''?>
    </p>
    <p>
        Error details:
        <br>
<pre>
<?php isset($data['errors']) ? var_dump($data['errors']) : print(''); ?>
</pre>
    </p>
    <?php if (isset($data['exception']) && $data['exception']) { ?>
    <p>
        <i>Please download attachment for the exception details.</i>
    </p>
    <?php } ?>
    </body>
</html>