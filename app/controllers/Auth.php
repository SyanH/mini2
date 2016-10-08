<?php

namespace app\controllers;

class Auth extends \libs\Controller
{
	public function login()
	{
		$auth = new \app\models\Auth;
		if ($this->app->request->isAjax()) {
			$param = $this->app->request->getArray(['name', 'password', 'rememberMe']);
			$expire = $param['rememberMe'] == 1 ? 86400 : 0;
			$return = $auth->login($param['name'], $param['password'], $expire);
			if ($return) {
				$this->app->json(['status'=>1, 'role'=>$return['role']]);
			} else {
				$this->app->json(['status'=>0]);
			}
		} else {
			if ($auth->hasLogin()) { //登录过直接跳转首页
				$this->app->response->redirect($this->app->route(), 301);
			}
			$this->app->view('/app/views/login.php');
		}
	}

	public function reg()
	{
		if ($this->app->request->isAjax()) {
			$param = $this->app->request->getArray(['name', 'password', 'email', 'enpassword']);
            if (! preg_match('/^[a-z0-9_\x{4e00}-\x{9fa5}]{2,16}$/ui', $param['name'])) {
                $this->app->json(['status'=>-1, 'msg'=>'用户名必须是2-16位中文、英文、数字和下划线组合！']);
            }
            $this->app->db->query('SELECT uid FROM @table.user WHERE username = :username');
            $this->app->db->bind(':username', $param['name']);
            if ($this->app->db->fetch()) {
                $this->app->json(['status'=>-1, 'msg'=>'用户名已经存在！']);
            }
            if (false === filter_var($param['email'], \FILTER_VALIDATE_EMAIL)) {
                $this->app->json(['status'=>-1, 'msg'=>'邮箱格式不正确！']);
            }
            $this->app->db->query('SELECT uid FROM @table.user WHERE email = :email');
            $this->app->db->bind(':email', $param['email']);
            if ($this->app->db->fetch()) {
                $this->app->json(['status'=>-1, 'msg'=>'邮箱已经存在！']);
            }
            $passwordLen = mb_strlen($param['password'],'utf8');
            if ($passwordLen < 6 OR $passwordLen > 20) {
                $this->app->json(['status'=>-1, 'msg'=>'密码长度不能少于6位，大于20位！']);
            }
            if (strcmp($param['password'], $param['enpassword']) !== 0) {
                $this->app->json(['status'=>-1, 'msg'=>'密码和确认密码不一致！']);
            }
            $this->app->db->query('INSERT INTO @table.user (username, password, email, nickname, regtime, logintime) VALUES (:username, :password, :email, :nickname, :regtime, :logintime)');
            $this->app->db->bindArray([
                ':username' => $param['name'],
                ':password' => password_hash($param['password'], \PASSWORD_DEFAULT),
                ':email'    => $param['email'],
                ':nickname' => $param['name'],
                ':regtime'  => time(),
                ':logintime'=> time()
            ]);
            $this->app->db->execute();
            if ($this->app->db->rowCount() > 0) {
                $this->app->json(['status'=>1, 'msg'=>'注册成功! <a href="' . $this->app->route() . '">返回首页</a> OR <a href="' . $this->app->route('/login') . '">登录</a>']);
            } else {
                $this->app->json(['status'=>-1, 'msg'=>'注册失败！请联系管理员.']);
            }
		} else {
			$auth = new \app\models\Auth;
			if ($auth->hasLogin()) { //登录过直接跳转首页
				$this->app->response->redirect($this->app->route(), 301);
			}
			$this->app->view('/app/views/reg.php');
		}
	}

    public function logout()
    {
        $auth = new \app\models\Auth;
        $auth->logout();
        //退出后跳转首页
        $this->app->response->redirect($this->app->route(), 301);
    }
}