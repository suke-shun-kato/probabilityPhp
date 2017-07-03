<?php
/**
* 確率のkeyが入った連想配列（複数）から抽選するプログラム
* @param array[] $drawnAssoAry 抽選対象、連想配列の配列
* @param string $probKey 確率が入った連想配列のキー名
* @return array 連想配列
*/
function drawRelativeProb($drawnAssoAry, $probKey, $returnKey = false) {
    // ----------------------------------
    // 相対確率の合計値を求める
    // ----------------------------------
    $probSum = 0;
    foreach ($drawnAssoAry as $drawnAsso) {
        $probSum += $drawnAsso[$probKey];
    }

    // ----------------------------------
    // 例外処理、相対確率が全て0のとき、先にここで例外的に抽選してしまう
    // ----------------------------------
    if ($probSum == 0) {
        //// インデックスをランダムで決定する ////
        $randNum = randomFloatHigherThan(0, count($drawnAssoAry));
        $randIndex = ceil($randNum) - 1;
// var_dump($randIndex);
        //// 抽選を行う ////
        $i=0;
        foreach ($drawnAssoAry as $drawnAsso) {
            if ($i == $randIndex) {
                return $drawnAsso;
            }
            $i++;
        }
    }

    // ----------------------------------
    // 抽選本番
    // ----------------------------------
    $randNum = randomFloatHigherThan(0, $probSum);   //0～$sumまでのランダムな値（0は除く）
    $nowProb = 0;
    foreach ($drawnAssoAry as $key => $drawnAsso) {
        $nowProb += $drawnAsso[$probKey];
        if ($nowProb >= $randNum){
            if ($returnKey === true) {
                return $key;
            } else {
                return $drawnAsso;
            }
        }
    }
    throw new Exception('drawRelativeProb() end Error');
}

/**
* ランダムな数値を作成する関数（$higherThanより上、$max以下）
* @param float $higherThan 下限値（この値は含まれない）
* @param float $max 上限値
* @return float ランダムな数値
*/
function randomFloatHigherThan($higherThan = 0, $max = 1) {
    // ----------------------------------
    // エラー処理
    // ----------------------------------
    if ($higherThan >= $max) {
        throw new Exception('最小値>=最大値になってます');
    }

    // ----------------------------------
    // メイン処理
    // ----------------------------------
    $randNum = randomFloat($higherThan, $max);

    if ($randNum == 0) {    //ここは==で、floatとintの違い
        $randNum = randomFloatHigherThan($higherThan, $max);
    }
    return $randNum;
}

/**
* ランダムな数値を作成する関数（$min以上、$max以下）
* （参考、というかほぼ丸パクリ）http://php.net/manual/ja/function.mt-getrandmax.php
* @param float $min 下限値
* @param float $max 上限値
* @return float ランダムな数値
*/
function randomFloat($min = 0, $max = 1) {
    if ($min > $max) {
        throw new Exception('最小値>最大値になってます');
    }

    return $min + mt_rand() / mt_getrandmax() * ($max - $min);
}
