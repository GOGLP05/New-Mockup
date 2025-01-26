<?php
class keisan{
    public function decimalToFraction($decimal) {
        // 小数を分数に変換するために10の何乗かで掛ける
        $denominator = 100; // 0.75なら、分母は100
        $numerator = $decimal * $denominator;

        // 最大公約数を求める（ユークリッドの互除法）
        while ($denominator != 0) {
            $temp = $denominator;
            $denominator = $numerator % $denominator;
            $numerator = $temp;
        }

        // 最大公約数で割って約分する
        $gcd = $numerator;

        $numerator = ($decimal * 100) / $gcd;
        $denominator = 100 / $gcd;

        return $numerator . '/' . $denominator;
    }
}
?>