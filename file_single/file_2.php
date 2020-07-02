<?php
$huruf = "TranSISI";
$array = str_split($huruf, 1);
$no = 0;
foreach ($array as $val) {
  if (ctype_lower($val)) {
    $no++;
  }
}
echo "huruf " . $huruf . " mengandung " . $no . " buah huruf kecil";