<?php

namespace app\models;

use libs\Helper;

class Auth extends \libs\Model
{
	public static $role = [
		'admin' => 0,
		'vip' => 1,
		'user' => 2
	];
	public function login($name, $password, $expire = 0)
	{
		$selectField = filter_var($name, \FILTER_VALIDATE_EMAIL) === false ? 'username' : 'email';
		$this->db->query(sprintf('SELECT uid,username,email,nickname,role,password FROM @table.user WHERE %s = :username', $selectField));
		$this->db->bind(':username', $name);
		$user = $this->db->fetch();
		if (false === $user) {
			return false;
		}
		$hashValidate = password_verify($password, $user['password']);
		if ($user && $hashValidate) {
			$authCode = function_exists('openssl_random_pseudo_bytes') ?
                bin2hex(openssl_random_pseudo_bytes(16)) : sha1(Helper::randString(20));
            $this->app->response->setCookie('__' . $this->app->configs->name . '_uid', $user['uid'], $expire);
            $infoRandString = Helper::randString(10);
            $hash = base64_encode(Helper::hash($authCode) . '|' . $infoRandString . $this->app->configs->key);
            $this->app->response->setCookie('__' . $this->app->configs->name . '_authCode', $hash, $expire);
            unset($user['password']);
            $infoHash = Helper::encode($this->app->configs->key . '|' . implode('|', $user), $this->app->configs->key, true);
            $this->app->response->setCookie('__' . $this->app->configs->name . '_' . $infoRandString, $infoHash, $expire);
            $this->db->query('UPDATE @table.user SET logintime = :logintime, authcode = :authcode WHERE uid = :uid');
            $this->db->bindArray([
            	':logintime'   => time(),
            	':authcode' => $authCode,
            	':uid'      => $user['uid']
            ]);
            $this->db->execute();
			return $user;
		}
		return false;
	}

	public function logout()
	{
		$this->app->response->deleteCookie('__' . $this->app->configs->name . '_uid');
		$authCode = $this->app->request->getCookie('__' . $this->app->configs->name . '_authCode');
		if (null !== $authCode) {
			$code = explode('|', base64_decode($authCode), 2);
			$infoRandString = str_replace($this->app->configs->key, '', $code[1]);
			$this->app->response->deleteCookie('__' . $this->app->configs->name . '_' . $infoRandString);
			$this->app->response->deleteCookie('__' . $this->app->configs->name . '_authCode');
		}
	}

	public function hasLogin()
	{
		$cookieUid = $this->app->request->getCookie('__' . $this->app->configs->name . '_uid');
		$cookieAuthCode = $this->app->request->getCookie('__' . $this->app->configs->name . '_authCode');
		if (null === $cookieUid || null === $cookieAuthCode) {
			return false;
		} else {
			$code = explode('|', base64_decode($cookieAuthCode), 2);
			if (count($code) !== 2) {
				return false;
			}
			$infoRandString = str_replace($this->app->configs->key, '', $code[1]);
			$cookieUserInfo = $this->app->request->getCookie('__' . $this->app->configs->name . '_' . $infoRandString);
			if (null === $cookieUserInfo) {
				return false;
			}
			$this->db->query('SELECT authcode FROM @table.user WHERE uid = :uid');
			$this->db->bind(':uid', intval($cookieUid));
			$user = $this->db->fetch();
			if ($user && Helper::hashValidate($user['authcode'], $code[0])) {
                return true;
            }
            $this->logout();
		}
		return false;
	}

	public function getUser($key = null)
	{
		$cookieUid = $this->app->request->getCookie('__' . $this->app->configs->name . '_uid');
		$cookieAuthCode = $this->app->request->getCookie('__' . $this->app->configs->name . '_authCode');
		if (null === $cookieUid || null === $cookieAuthCode) {
			return null;
		} else {
			$code = explode('|', base64_decode($cookieAuthCode), 2);
			if (count($code) !== 2) {
				return null;
			}
			$infoRandString = str_replace($this->app->configs->key, '', $code[1]);
			$cookieUserInfo = $this->app->request->getCookie('__' . $this->app->configs->name . '_' . $infoRandString);
			if (null === $cookieUserInfo) {
				$this->logout();
				return null;
			}
			$info = explode('|', Helper::decode(base64_decode($cookieUserInfo), $this->app->configs->key));
			unset($info[0]);
			$userData = ['uid'=>$info[1], 'username'=>$info[2], 'email'=>$info[3], 'nickname'=>$info[4], 'role'=>$info[5]];
			if (null !== $key && isset($userData[$key])) {
				return $userData[$key];
			}
			return $userData;
		}
	}

	public function pass($role, $view = false)
	{
		if ($this->hasLogin()) {
			$userRole = $this->getUser('role');
			if (array_key_exists($role, self::$role) && self::$role[$userRole] <= self::$role[$role]) {
				return true;
			}
		}
		if ($view) {
			$body = $this->app->view('/libs/views/403.php', [], true);
			$this->app->halt(403, $body);
		}
		return false;
	}
}