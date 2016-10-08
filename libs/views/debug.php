<html>
<head>
    <meta charset="<?php echo $this->configs->charset; ?>">
    <title>error</title>
    <style type="text/css">
    * { box-sizing: border-box;}
    body {
        font-family: "Helvetica Neue", "HelveticaNeue", Helvetica, Arial, "Lucida Grande", sans-serif;
        font-size: 18px;
        font-style: normal;
        font-weight: normal;
        text-transform: normal;
        letter-spacing: normal;
        line-height: 1.4em;
        color:black;
        background-color:#eee;
    }
    h1 { font-size:44px;letter-spacing: -2px;line-height: 1em;margin:0; }
    h2 { font-size:16px;font-weight:normal;color:#999; }
    h3 { font-weight:bold;font-size:11pt}
    p  { margin-top: 5px 0px;}
    .wrapper{width:940px;margin: 20px auto;}
    .content {
        background-color:white;
        border: 1px #ccc solid;
        padding:20px;
        border-radius: 3px;
        box-shadow:0px 0px 5px #ccc;
    }
    .italic {font-family: Georgia;}
    .code {
        color: #fff;
        background-color: #000;
        padding: 10px;
        font-size: 14px;
        border-radius: 4px;
    }
    pre{font-family: Consolas, Monaco, 'Andale Mono', monospace;}
    .code ol {overflow-x: auto;padding-left: 50px;}
    .code li{color:#7dd1ca;}
    .code li span{color:#afb0cb;display: block;}
    .code li:hover{background-color: #333;}
    .code li.selected span{background: #de0669;color: #fff;}
    .version {margin-top: 30px;padding-top: 10px;color: gray;font-size:8pt;border-top:1px #eee solid;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h1>error</h1>
        <h2 style="color:#de0669;"><?php echo nl2br($e->getMessage()); ?></h2>
    </div>
    <div class="wrapper content">
        <p>
            <strong><?php echo $e->getFile(); ?></strong><br />
            <span class="italic">on line <?php echo $e->getLine(); ?></span>
            <div class="code"><?php
    $f = $e->getFile();
    $l = $e->getLine();
    $files = file($f);
    $count = count($files);
    $before = $l-6;
    $later = $l+6;
    if ($count > 13) {
        echo '<pre><ol start="' . $before . '">';
    } else {
        echo '<pre><ol>';
    }
    $i = 0;
    foreach ($files as $fi) {
        $fi = preg_replace("/[\t]/","&ensp;&ensp;&ensp;&ensp;",$fi);
        $fi = preg_replace("/[\s]/","&ensp;",$fi);
        $fi = str_replace("&amp;","&",htmlentities($fi));
        $i++;
        $selected = ($i == $l) ? ' class="selected"' : '';
        if ($count > 13) {
            if ($i < $before OR $i > $later) {
                continue;
            } else {
                echo '<li'.$selected.'><span>'.$fi.'</span></li>';
            }
        } else {
            echo '<li'.$selected.'><span>'.$fi.'</span></li>';
        }
    }
?>
</ol></pre></div>
        </p>
        <div class="version">
            Debug.
        </div>
    </div>
</body>
</html>