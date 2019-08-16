<?php
/**
 * @author donknap
 * @date 19-3-2 下午1:48
 */

namespace W7\App\Controller;


use W7\Core\Controller\ControllerAbstract;
use W7\Http\Message\File\File;
use W7\Http\Message\Server\Request;

class HomeController extends ControllerAbstract {
	public function index(Request $request) {
		idd($request);
		return [
			'data' => [
				'uid' => 1,
				'username' => 'rangine'
			]
		];
	}

	public function session(Request $request) {
		$request->session->set('test', 1);
		var_dump($request->session->get('test'));

		return true;
	}

	public function userLogin(Request $request, $uid = 0) {
		return 'user-login ---- uid : ' . $uid . ' --- post: ' . $request->post('password');
	}

	public function download() {
		return $this->response()->withFile(new File('/home/data/1.txt'));
	}

	public function userheader() {
		return $this->response()->withHeader('Content-Type', 'text/html;charset=utf-8')->withContent('withheader');
	}
}