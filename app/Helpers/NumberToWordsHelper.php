<?php
// app/Helpers/NumberToWordsHelper.php

if (!function_exists('numberToWords')) {
  function numberToWords($number)
  {
    // Array to represent the number words from 0 to 19
    $wordsArray = [
      0 => 'zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four',
      5 => 'Five', 6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
      10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen',
      15 => 'Fifteen', 16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen'
    ];

    // Array to represent the number words for multiples of 10
    $tensArray = [
      20 => 'Twenty', 30 => 'Thirty', 40 => 'Forty', 50 => 'Fifty',
      60 => 'Sixty', 70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety'
    ];

    if ($number < 20) {
      return $wordsArray[$number];
    }

    if ($number < 100) {
      return $tensArray[$number - ($number % 10)] . (($number % 10 !== 0) ? ' ' . $wordsArray[$number % 10] : '');
    }

    if ($number < 1000) {
      return $wordsArray[floor($number / 100)] . ' Hundred' . (($number % 100 !== 0) ? ' and ' . numberToWords($number % 100) : '');
    }

    if ($number < 1000000) {
      $thousands = floor($number / 1000);
      $remainder = $number % 1000;
      return numberToWords($thousands) . ' Thousand' . (($remainder !== 0) ? ' ' . numberToWords($remainder) : '');
    }

    return 'number is out of range';
  }
}
