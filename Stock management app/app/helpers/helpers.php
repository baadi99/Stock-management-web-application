<?php 

//To avoid naming collisions
if (! function_exists('format_money')) {
    /**
     * A function to format money in the format x K/M/B e.g. 15K
     */

    function format_money($number) {

        $postfixs = ['k', 'M', 'B', 'T'];
        //Convert the number to string to ease the calculation of the number of its digits
        //and we use round to ignore the decimal part 
        
        $num_to_string = (string)(round($number));
        //Get the length of the string
        $length = strlen($num_to_string);
        //Determine the number of the main digits (number is displayed as : main_digits K/M/B)
        //This is necessary so for example 150_000 will be formated to 150k instead of 0.15M
        $num_main_digits = ($length % 3 === 0 && $number > 999) ? 3 : $length % 3;  
        //Determine the index of the appropriate postfix 
        $index = ($length - $num_main_digits) / 3;
        //Construct the final format
        $formatted = '&dollar;'.round($number / pow(1000, $index), 2).$postfixs[$index - 1];
    
        return $formatted;
    }
}
?>