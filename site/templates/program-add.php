<?php
	use Dplus\Processwire\DplusWire;

	$programs = DplusWire::wire('modules')->get('EicapPrograms');

	if ($input->requestMethod('POST')) {
		$programcode = $input->post->text('program-code');
		$programtitle = $input->post->text('program-title');

		if ($programs->does_programexist($programcode)) {
			$success = false;
		} else {
			$success = $programs->add_program($programcode, $programtitle);
		}
	}

	$inputpost = $input->requestMethod('POST');

	if ($user->is_admin()) {
		$page->body = $config->twig->render('programs/program-add.twig', ['page' => $page, 'inputpost' => $inputpost, 'success' => $success, 'programcode' => $programcode, 'programtitle' => $programtitle]);
	} else {
		$page->body = $config->twig->render('common/error-page.twig', ['title' => 'Error!', 'msg' => "You don't have permission to this function"]);
	}
	include __DIR__ . "/basic-page.php";
