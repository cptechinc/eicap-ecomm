<?php
	if ($user->is_admin()) {
		$userID = $input->get->text('user');

		if ($users->find("name=$userID")->count) {
			$edituser = $users->get("name=$userID");
			$programs = $modules->get('EicapPrograms')->get_programs();
			$page->title = "Editing User $edituser->name";

			if ($input->requestMethod('POST')) {
				$edituser->of(false);

				foreach ($programs as $program) {
					if (strtoupper($input->post->text($program->name)) == "Y") {
						if (!$edituser->in_program($program->program)) {
							$edituser->add_program($program->program);
						}
					} else {
						if ($edituser->in_program($program->program)) {
							$edituser->remove_program($program->program);
						}
					}
				}
				$edituser->save();
				$edituser->of(true);
			}

			$page->body = $config->twig->render('user/edit-user.twig', ['page' => $page, 'edituser' => $edituser, 'programs' => $programs]);
		} else {
			$page->body = $config->twig->render('common/error-page.twig', ['title' => 'Error!', 'msg' => "User ID $userID not found"]);
		}
	} else {
		$page->body = $config->twig->render('common/error-page.twig', ['title' => 'Error!', 'msg' => "You don't have permission to this function"]);
	}
	include __DIR__ . "/basic-page.php";
