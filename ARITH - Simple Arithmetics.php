<?php

/*
    Simple function to grab stidn input
*/
function getInput(string|null $text = null):string|false
{
    if(is_string($text)){
        echo $text;
    }
    $handle = fopen ("php://stdin","r");
    $handle = fgets($handle);
    if(is_string($handle) && trim($handle) === 'exit'){
        echo "Bye!\n";
        exit;
    }
    return $handle;
}


/*
    Function to check that array contains string values from array
*/
function stringContainsArray(string|false $str, array $arr):bool
{
    foreach($arr as $a) {
        if (stripos($str,$a) !== false) return true;
    }
    return false;
}


/*
    Function to handle calculations and print them.
*/
function calculateExpression(string $expr):void{
    if(str_contains($expr, "+") || str_contains($expr, "-")){
        $str_bool = str_contains($expr, "+");
        $operator = ($str_bool === true)? "+": "-";
        $explode = explode($operator, $expr);
        $num1 = intval($explode[0]);
        $num2 = intval($explode[1]);
        ($str_bool)? $result = strval($num1 + $num2) : $result = strval($num1 - $num2);
        $field = max(strlen($num1), strlen($expr[1]), strlen($result));
        echo "\n";
        printf("%" . $field . "s\n", $num1);
        printf("%" . $field . "s", $operator.$explode[1]);
        printf("%" . $field . "s\n", str_repeat("-", max(strlen($result), strlen($expr[1]))));
        printf("%" . $field . "s\n", $result);
        echo "\n";
    }
    else if(str_contains($expr, "*")){
        $explode = explode('*', $expr);
        $a = intval($explode[0]); 
        $b = intval($explode[1]); 
        $tmp = strval($b); 

        $res = [];
        for ($i = strlen($tmp) - 1; $i >= 0; $i--) {
            $res[] = strval($a * intval($tmp[$i]));
        }

        $finres = strval($a * $b); 

        $field = max(strlen($explode[0]), strlen($explode[1]) + 1, strlen($finres), strlen(end($res)) + count($res) - 1);
        echo "\n";
        printf("%" . $field . "s\n", $explode[0]);
        printf("%" . $field . "s", "*" . $explode[1]);
        printf("%" . $field . "s\n", str_repeat("-", max(strlen($res[0]), strlen($explode[1]) + 1)));
        if (count($res) > 1) {
            for ($i = 0; $i < count($res); $i++) {
                printf("%" . ($field - $i) . "s%-" . $i . "s\n", $res[$i], " ");
            }
            printf("%" . $field . "s\n", str_repeat("-", max(strlen(end($res)) + count($res) - 1, strlen($finres))));
        }
        printf("%" . $field . "s\n", $finres);
        echo "\n";

    }else{
        echo "\nNo valid operator provided for this calculation $expr\n";
    }

}

/*
    Function to collect expressions 
*/
function collectExpressions(int $count, array &$expressions  = []):void{
    for($i = 0; $i < $count; $i++){
        $output = getInput("Type arithmetics calculation, should contains one of -,+,*\n or 'exit' to leave \n");
        if(stringContainsArray($output, ['+', '-', '*'])){
            $expressions[] = $output;
        }else{
            echo "\nNo valid operator provided, type arithmetics calculation with -,+,*\n";
            collectExpressions(1, $expressions);
        }


    }
}

//collect count of collections to perform
$count = getInput("Type number of arithmetics calc to perform, type 'exit' to leave\n");

if(is_numeric($count) && $count > 0){
    //collect expressions
    $expressions = [];
    collectExpressions($count, $expressions);
    //and.. after that calculate them and print
    foreach($expressions as $expr){
        calculateExpression($expr);
    }
}else{
    echo "Bye!\n";
    exit;
}

?>
