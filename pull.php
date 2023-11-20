<?php
function execPrint($command) {
    $result = array();
    exec($command, $result);
    foreach ($result as $line) {
        print($line . "<br>");
    }
}
print("<pre>" . execPrint("git pull https://PankajBrightcodess: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@github.com/PankajBrightcodess/dream_touch.git main")."</pre>");
?>
