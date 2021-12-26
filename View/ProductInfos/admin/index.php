<table cellpadding="0" cellspacing="0" class="list-table bca-form-table" id="ListTable">
	<?php foreach ($datas as $key => $data) : ?>
		<tr>
			<th class="col-head bca-form-table__label" style="width: 30%;"><?php echo h($data['name']) ?></th>
			<td class="col-input bca-form-table__input" style="width: 70%;"><?php echo h($data['value']) ?></td>
		</tr>
	<?php endforeach; ?>
</table>
<!-- button -->
<div class="bca-actions">
	<?php
	$this->BcBaser->link(
		__d('baser', 'CSVダウンロード'),
		[
			'action' => 'download_csv'
		],
		[
			'class' => 'button bca-btn bca-actions__item',
			'data-bca-btn-size' => 'sm',
		],
		sprintf(__d('baser', '情報をCSV形式でダウンロードしますか？')),
		false
	);
	?>
	<?php
	$this->BcBaser->link(
		__d('baser', 'TSVダウンロード'),
		[
			'action' => 'download_tsv'
		],
		[
			'class' => 'button bca-btn bca-actions__item',
			'data-bca-btn-size' => 'sm',
		],
		sprintf(__d('baser', '情報をTSV形式でダウンロードしますか？')),
		false
	);
	?>
</div>
