<?php
// $uuu=randomFloatHigherThan(1,4);
// var_dump($uuu);exit;

// 
// $ary = [
//     ['name' => 'bbbb', 'prob' => 1],
//     ['name' => 'cccc', 'prob' => 2],
//     ['name' => 'dddd', 'prob' => 0.5],
//     ['name' => 'eeee', 'prob' => 1],
// ];
// var_dump($ary);
//
// $ssss = drawRelativeProb($ary, 'prob');
// var_dump($ssss);


/**
* 確率のkeyが入った連想配列（複数）から抽選するプログラム
* @param array[] $drawnAssoAry 抽選対象、連想配列の配列
* @param string $probKey 確率が入った連想配列のキー名
* @return array 連想配列
*/
function drawRelativeProb($drawnAssoAry, $probKey) {
    // ----------------------------------
    // 相対確率の合計値を求める
    // ----------------------------------
    $probSum = 0;
    foreach ($drawnAssoAry as $drawnAsso) {
        $probSum += $drawnAsso[$probKey];
        // $probSum += $drawnAsso->$probKey;
    }
    // ----------------------------------
    // 抽選
    // ----------------------------------
    $randNum = randomFloatHigherThan(0, $probSum);   //0～$sumまでのランダムな値（0は除く）
    $nowProb = 0;
    foreach ($drawnAssoAry as $key => $drawnAsso) {
        $nowProb += $drawnAsso[$probKey];
        // $nowProb += $drawnAsso->{$probKey};
        if ($nowProb >= $randNum){
            return $drawnAsso;
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
