<?php


    $nilai = "72 65 73 78 75 74 90 81 87 65 55 69 72 78 79 91 100 40 67 77 86";
    $ex = explode(' ', $nilai);
    $no = 0;
    $sum = 0;
    foreach ($ex as $val) {
      $no++;
      $sum = $sum + $val;
    }
    echo " nilai rata - rata :  " . $sum . "<br>";
    echo "<br> nilai max " . max($ex) . "<br>";
    echo "<br> nilai max " . min($ex) . "<br>";
    