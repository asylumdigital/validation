<?php
require_once 'ci/boot.php';

$rows = array_map(function($v) {
    return [$v['rule'], $v['description']];
}, get_gump_validators());

$tableBuilder = new \MaddHatter\MarkdownTable\Builder();

$tableBuilder
	->headers(['Rule','Description'])
	->align(['L','L'])
	->rows($rows);

$readme = file_get_contents(README_FILE);

$regex = '/(?<=<details><summary>Show all validators<.summary><div><br>)(.*?)(?=<.div><.details>)/ms';

$replaced = preg_replace($regex, PHP_EOL.PHP_EOL.$tableBuilder->render(), $readme);

file_put_contents(README_FILE, $replaced);

print('Docs updated!'.PHP_EOL);

