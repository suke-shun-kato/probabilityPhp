<?php
require_once( __DIR__ . '/drawFromAsso.php' );
//// 設定値 ////
$originProbAry = [
    'tttt' => ['name' => 'bbbb', 'prob' => 2],
    ['name' => 'eeee', 'prob' => 1],
    ['name' => 'ssss', 'prob' => 1],
    ['name' => 'ffff', 'prob' => 0.5],
    ['name' => 'ffff', 'prob' => 0.5]
];
const NUM_EEEE = 100000;

//// 元の確率を絶対確率へ ////
$originAbsoProbAssoAry = calcAbsoluteProb($originProbAry, 'prob');
//// 検証 ////
foreach ($originProbAry as $key => $value) {  //先に空の変数作成
    $drewnRelaProbAssoAry[$key]['prob'] = 0;
}
for ($i = 0; $i < NUM_EEEE; $i++) {
    $drewnKey = drawRelativeProb($originProbAry, 'prob', true);
    $drewnRelaProbAssoAry[$drewnKey]['prob']++;
}
$drewnAbsoProbAssoAry = calcAbsoluteProb($drewnRelaProbAssoAry, 'prob');

//// 表示用 ////
echo '元';
var_dump($originAbsoProbAssoAry);
echo 'ランダム抽選後';
var_dump($drewnAbsoProbAssoAry);

/**
* 相対確率→絶対確率 変換
*/
function calcAbsoluteProb($probAssoAry, $probKey) {
    $probSum = 0;
    foreach ($probAssoAry as $key => $probAsso) {
        $probSum += $probAsso[$probKey];
    }

    $rtnAssoAry = [];
    foreach ($probAssoAry as $key => $probAsso) {
        foreach ($probAsso as $assoKey => $value) {
            if ($assoKey == $probKey) {
                $rtnAssoAry[$key][$assoKey] = $probAsso[$probKey]/$probSum;
            } else {
                $rtnAssoAry[$key][$assoKey] = $value;
            }
        }
    }

    return $rtnAssoAry;
}
