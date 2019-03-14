<?php
	if ($input->requestMethod('POST')) {
		$programcode = $input->post->text('program-code');
		$programtitle = $input->post->text('program-title');

		if (does_programexist($programcode)) {
			$success = false;
		} else {
			$success = add_program($programcode, $programtitle);
		}
	}

	$inputpost = $input->requestMethod('POST');

	$page->body = $config->twig->render('programs/program-add.twig', ['page' => $page, 'inputpost' => $inputpost, 'success' => $success, 'programcode' => $programcode, 'programtitle' => $programtitle]);
	include __DIR__ . "/basic-page.php";
