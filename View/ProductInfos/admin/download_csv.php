<?php
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=product_info" . date('Ymd') .  ".csv");
header("Content-Transfer-Encoding: base64");
$csv = '';
$head = '';
$body = '';
foreach ($datas as $data) {
	$head .= '"' . $data['name'] . '",';
	$body .= '"' . $data['value'] . '",';
}
$csv = "\xEF\xBB\xBF" . $head . "\n" . $body;
echo $csv;
exit;
