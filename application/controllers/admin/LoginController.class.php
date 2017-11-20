<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-10-31
 * Time: 17:04
 */

class LoginController extends  Controller{

    //载入登录页面，http://127.0.0.1/shopcz/index.php?p=admin&c=Login&a=login
    public function loginAction(){
        include  CUR_VIEW_PATH."login.html";
    }

    //登录操作，http://127.0.0.1/shopcz/index.php?p=admin&c=Login&a=signin
    public function signinAction()
    {
        //0.验证验证码
        var_dump($_POST);
        $captcha = trim($_POST['captcha']);
        if(strtolower($captcha) != $_SESSION['captcha']){
            $this->jump("index.php?p=admin&c=login&a=login","验证码不正确",3);
        }

        //1. 手机用户名和密码
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        //2. 验证处理数据
        //3. 调用模型来进行验证，给出提示
        $adminModel = new AdminModel('admin');
        $userinfo = $adminModel->checkUser($username, $password);
        if (empty($userinfo)) {
            //不存在该用户
            $this->jump("index.php?p=admin&c=Login&a=login", "不存在该用户", 3);
        } else {
            $_SESSION['admin'] = $userinfo;
            $this->jump("index.php?p=admin&c=Index&a=index", "登陆成功", 3);
        }
    }


    //注销用户,http://127.0.0.1/shopcz/index.php?p=admin&c=Login&a=logout
    public function logoutAction(){
            unset($_SESSION['admin']);
            session_destroy();
            $this->jump("index.php?p=admin&c=login&a=login","注销成功",0);
        }

    //生成验证码,http://127.0.0.1/shopcz/index.php?p=admin&c=Login&a=captcha
    public function captchaAction(){

        $this->library("Captcha");
        $c = new Captcha();
        $c->generateCode();
        $_SESSION['captcha'] = $c->getCode();
    }

}