<?php
	$userID = $input->get->text('user');
	$edituser = $users->get("name=$userID");
	$edituser->of(false);
	$logmuser = LogmUser::load($userID);
	$programs = $pages->get('/config/programs/')->children();

	if ($input->requestMethod('POST')) {
		foreach ($programs as $program) {
			$programcode = get_processwireprogramcode($program->name);

			if (strtoupper($input->post->text($programcode)) == "Y") {
				if (!$edituser->hasRole($programcode)) {
					$edituser->addRole($programcode);
				}
			} else {
				if ($edituser->hasRole($programcode)) {
					$edituser->removeRole($programcode);
				}
			}
		}
		$edituser->save();
		$edituser->of(true);
	}
	$page->title = "Editing User $edituser->name";
	$dplusrole = $logmuser ? $config->user_roles[$logmuser->get_dplusorole()]['label'] : 'Not Found';

	if ($user->is_admin()) {
		$page->body = $config->twig->render('user/edit-user.twig', ['page' => $page, 'edituser' => $edituser, 'programs' => $programs, 'dplusrole' => $dplusrole]);
	} else {
		$page->body = $config->twig->render('common/error-page.twig', ['title' => 'Error!', 'msg' => "You don't have permission to this function"]);
	}
	include __DIR__ . "/basic-page.php";
