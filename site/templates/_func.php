<?php
	use Dplus\ProcessWire\DplusWire;
/**
 * Shared functions used by the beginner profile
 *
 * This file is included by the _init.php file, and is here just as an example.
 * You could place these functions in the _init.php file if you prefer, but keeping
 * them in this separate file is a better practice.
 *
 */

/**
 * Given a group of pages, render a simple <ul> navigation
 *
 * This is here to demonstrate an example of a simple shared function.
 * Usage is completely optional.
 *
 * @param PageArray $items
 *
 */
function renderNav(PageArray $items) {

	if(!$items->count()) return;

	echo "<ul class='nav' role='navigation'>";

	// cycle through all the items
	foreach($items as $item) {

		// render markup for each navigation item as an <li>
		if($item->id == wire('page')->id) {
			// if current item is the same as the page being viewed, add a "current" class to it
			echo "<li class='current' aria-current='true'>";
		} else {
			// otherwise just a regular list item
			echo "<li>";
		}

		// markup for the link
		echo "<a href='$item->url'>$item->title</a> ";

		// if the item has summary text, include that too
		if($item->summary) echo "<div class='summary'>$item->summary</div>";

		// close the list item
		echo "</li>";
	}

	echo "</ul>";
}


/**
 * Given a group of pages render a tree of navigation
 *
 * @param Page|PageArray $items Page to start the navigation tree from or pages to render
 * @param int $maxDepth How many levels of navigation below current should it go?
 *
 */
function renderNavTree($items, $maxDepth = 3) {

	// if we've been given just one item, convert it to an array of items
	if($items instanceof Page) $items = array($items);

	// if there aren't any items to output, exit now
	if(!count($items)) return;

	// $out is where we store the markup we are creating in this function
	// start our <ul> markup
	echo "<ul class='nav nav-tree' role='navigation'>";

	// cycle through all the items
	foreach($items as $item) {

		// markup for the list item...
		// if current item is the same as the page being viewed, add a "current" class and
		// visually hidden text for screen readers to it
		if($item->id == wire('page')->id) {
			echo "<li class='current' aria-current='true'><span class='visually-hidden'>Current page: </span>";
		} else {
			echo "<li>";
		}

		// markup for the link
		echo "<a href='$item->url'>$item->title</a>";

		// if the item has children and we're allowed to output tree navigation (maxDepth)
		// then call this same function again for the item's children
		if($item->hasChildren() && $maxDepth) {
			renderNavTree($item->children, $maxDepth-1);
		}

		// close the list item
		echo "</li>";
	}

	// end our <ul> markup
	echo "</ul>";
}

/**
 * Returns a template file URL with its hash value
 * // NOTE USED FOR JS / CSS FILES
 * @param	string $filename File to get URL and HasH for
 * @return string				URL to file with Hash Value
 */
function hash_templatefile($filename) {
	$hash = hash_file(DplusWire::wire('config')->userAuthHashType, DplusWire::wire('config')->paths->templates.$filename);
	return DplusWire::wire('config')->urls->templates.$filename.'?v='.$hash;
}

/**
 * Writes an array one datem per line into the dplus directory
 * @param array  $data	   Array of Lines for the request
 * @param string $filename Filename
 * @return void
 */
function write_dplusfile($data, $filename) {
	$file = '';
	foreach ($data as $line) {
		$file .= $line . "\n";
	}
	$vard = "/usr/capsys/ecomm/" . $filename;
	$handle = fopen($vard, "w") or die("cant open file");
	fwrite($handle, $file);
	fclose($handle);
}

/**
 * Sends a cURL (GET) Request to a URL
 * @param	string $url URL to Send cURL Request
 * @return string		Response
 */
function curl_get($url) {
	$curl = curl_init();
	curl_setopt_array($curl, array(
		CURLOPT_RETURNTRANSFER => 1,
		CURLOPT_URL => $url,
		CURLOPT_FOLLOWLOCATION => true
	));
	return curl_exec($curl);
}

/* =============================================================
	PROCESSWIRE USER FUNCTIONS
============================================================ */
	function setup_user($sessionID) {
		$loginrecord = get_loginrecord($sessionID);
		$loginID = $loginrecord['loginid'];
		$user = LogmUser::load($loginID);
		DplusWire::wire('user')->fullname = $loginrecord['loginname'];
		DplusWire::wire('user')->loginid = $loginrecord['loginid'];
		DplusWire::wire('user')->has_customerrestrictions = $loginrecord['restrictcustomers'];
		DplusWire::wire('user')->salespersonid = $loginrecord['salespersonid'];
		DplusWire::wire('user')->mainrole = $user->get_dplusrole();
		DplusWire::wire('user')->addRole($user->get_dplusrole());
		$roles = DplusWire::wire('users')->get("name=$user->loginid")->roles;

		foreach ($roles as $role) {
			DplusWire::wire('user')->addRole($role->name);
		}
	}

	/**
	 * Returns a list of Program Codes that this user has access to
	 * via Processwire Roles
	 * @param  string $loginID User Login ID
	 * @return array           Program Codes
	 */
	function get_customertypesforuser($loginID) {
		$user_processwire = DplusWire::wire('users')->get($loginID);
		$customertypes = array();

		foreach (DplusWire::wire('pages')->get('/config/programs/')->children() as $program) {
			if ($user_processwire->hasRole(get_processwireprogramcode($program->name))) {
				$customertypes[] = $program->name;
			}
		}
		return $customertypes;
	}

	/**
	 * Returns a list of Processwire Program Code Role that correspond with the
	 * Program codes the user has access to
	 * @param  string $loginID User Login ID
	 * @return array           Processwire Program Roles e.g. (program-hdst)
	 */
	function get_programtypesforuser($loginID) {
		$user_processwire = DplusWire::wire('users')->get($loginID);
		$programs = array();

		foreach (DplusWire::wire('pages')->get('/config/programs/')->children() as $program) {
			if ($user_processwire->hasRole(get_processwireprogramcode($program->name))) {
				$programs[] = get_processwireprogramcode($program->name);
			}
		}
		return $programs;
	}

	/**
	 * Returns the Processwire Role for provided Program
	 * @param  string $program Program Code
	 * @return string          Processwire Role Code
	 */
	function get_processwireprogramcode($program) {
		return "program-$program";
	}

	/**
	 * Returns the Sales Reps Login IDs that have access to the provided programs
	 * @param  array  $programs Processwire Program Roles e.g. (program-hdst)
	 * @return array            Sales Rep Login IDs
	 */
	function find_salesrepsbyprograms(array $programs) {
		$reps = array();
		$programstring = implode(',', $programs);
		$repsfortype = DplusWire::wire('users')->find("template=user, roles=$programstring");

		foreach ($repsfortype as $rep) {
			$reps[] = $rep->name;
		}
		return $reps;
	}

	/**
	 * Returns the Sales Rep IDs (NOT LOGIN IDs)
	 * @param  array  $programs Processwire Program Roles e.g. (program-hdst)
	 * @return array            Sales Rep Login IDs
	 */
	function find_salesrepidsbyprograms(array $programs) {
		$reps = array();
		$logins = find_salesrepsbyprograms($programs);

		foreach ($logins as $login) {
			$user = LogmUser::load($login);

			if (!empty($user->roleid)) {
				$reps[] = $user->roleid;
			}
		}
		return $reps;
	}

	function import_logmintoprocesswire() {
		$userlist = array();
		$logmusers = LogmUser::load_userlist();

		foreach ($logmusers as $logmuser) {
			if ($logmuser->loginid != 'apache') {
				$u = DplusWire::wire('users')->get("name=$logmuser->loginid");

				if (get_class($u) !== 'ProcessWire\Page' && get_class($u) !== 'ProcessWire\User') {
					$u = new User();
					$u->of(false);
					$u->name = $logmuser->loginid;
					$u->email = $logmuser->email;
					$u->pass = "P@55word";
					$u->addRole($logmuser->get_dplusorole());
				    $userlist[$logmuser->loginid] = $u->save();
				} else {
					$userlist[$logmuser->loginid] = true;
				}
			} else {
				$userlist[$logmuser->loginid] = false;
			}

		}
		return $userlist;
	}
