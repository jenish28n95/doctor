<?php
// app/Helpers/NumberToWordsHelper.php

if (!function_exists('numberToWords')) {
  function numberToWords($number)
  {
    // Array to represent the number words from 0 to 19
    $wordsArray = [
      0 => 'zero', 1 => 'one', 2 => 'two', 3 => 'three', 4 => 'four',
      5 => 'five', 6 => 'six', 7 => 'seven', 8 => 'eight', 9 => 'nine',
      10 => 'ten', 11 => 'eleven', 12 => 'twelve', 13 => 'thirteen', 14 => 'fourteen',
      15 => 'fifteen', 16 => 'sixteen', 17 => 'seventeen', 18 => 'eighteen', 19 => 'nineteen'
    ];

    // Array to represent the number words for multiples of 10
    $tensArray = [
      20 => 'twenty', 30 => 'thirty', 40 => 'forty', 50 => 'fifty',
      60 => 'sixty', 70 => 'seventy', 80 => 'eighty', 90 => 'ninety'
    ];

    if ($number < 20) {
      return $wordsArray[$number];
    }

    if ($number < 100) {
      return $tensArray[$number - ($number % 10)] . (($number % 10 !== 0) ? ' ' . $wordsArray[$number % 10] : '');
    }

    if ($number < 1000) {
      return $wordsArray[floor($number / 100)] . ' hundred' . (($number % 100 !== 0) ? ' and ' . numberToWords($number % 100) : '');
    }

    return 'number is out of range';
  }
}
