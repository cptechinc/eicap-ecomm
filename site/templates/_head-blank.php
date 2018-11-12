<!DOCTYPE html>
<html lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />
		<title><?= $page->title; ?></title>
		<meta name="description" content="<?php echo $page->summary; ?>" />
		<link rel="icon" href="<?= $site->company_favicon->url; ?>" type="image/x-icon">
		<link rel="apple-touch-icon" href="<?= $site->company_favicon->url; ?>"> 
		
		<?php foreach($config->styles->unique() as $css) : ?>
			<link rel="stylesheet" type="text/css" href="<?= $css; ?>" />
		<?php endforeach; ?>
	</head>

	<body>
