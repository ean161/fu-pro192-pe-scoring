<?php
error_reporting(0);

$test = 0;
$dir = $argv[1];

chdir("dataset/".$dir);
echo chr(27).chr(91).'H'.chr(27).chr(91)."J\n".strtoupper($dir)." REPORT\n\n";

$point = 10;
$corrected = 0;
for($i = 1; $i <= 100; $i++){
    $test++;
    unlink("input.txt");
    unlink("ouput.txt");
    unlink("self_out_".$i.".txt");
    copy($i.".in.txt", "input.txt");
    exec("java -jar Q1.jar 2>&1", $output, $exception);
    unlink($i.".out.bak");
    copy("output.txt", $i.".out.bak");

    $requireOut = file($i.".out.txt");
    $selfOut = file("output.txt");

    $requireLine = count($requireOut);
    $selfLine = count($selfOut);

    if(!$requireOut[$requireLine - 1])
        $requireLine--;
    if(!$selfOut[$selfLine - 1])
        $selfLine--;

    $wrongPosition = "";
    $correctedLine = 0;
    $inCorrectedLine = [];
    
    for($j = 0; $j < count($requireOut); $j++){
        $selfData = preg_replace( "/\r|\n/", "", $selfOut[$j]);
        $requireData = preg_replace( "/\r|\n/", "", $requireOut[$j]);

        if(strcmp($requireData, $selfData) == 0)
            $correctedLine++;
        else 
            $wrongPosition .= "     + [Line ".($j + 1).", unmatch] ".(!$selfData ? "No data" : compareStrings($requireData, $selfData))."\n";
    }

    if(($correctedLine == count($requireOut)) && ($requireLine == $selfLine)){
        $corrected++;
        echo "[#".$i."] \033[1;37m\033[1;42mCORRECT\033[1;0m\n";
    } else
        echo "[#".$i."] \033[1;37m\033[1;41mINCORRECT\033[1;0m ";
        if($exception)
            echo "\n     + Exception\n";
        else if($requireLine != $selfLine){
            echo "\n";
            for($k = $requireLine; $k < $selfLine; $k++)
                echo "     + [Line ".($k + 1).", not expected] \033[1;31m".$selfOut[$k]."\033[1;0m\n";
        } else
            echo "\n".$wrongPosition;
    echo "\n";
    if(!file_exists(($i + 1).".in.txt"))
        break;
}

echo "-> ".$corrected."/".$test." testcase corrected (".(($point / $test) * $corrected)." points)\n";

function compareStrings($str1, $str2) {
    $length1 = strlen($str1);
    $length2 = strlen($str2);
    $maxLength = max($length1, $length2);
    $result = "";

    for($i = 0; $i < $maxLength; $i++){
        $char1 = $i < $length1 ? $str1[$i] : "";
        $char2 = $i < $length2 ? $str2[$i] : "";

        if($char1 === $char2)
            $result .= $char1;
        else
            $result .= "\033[1;31m$char2\033[1;0m";
    }

    return $result;
}