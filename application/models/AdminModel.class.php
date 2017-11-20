<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-10-13
 * Time: 17:20
 */
class AdminModel extends Model{

    //数据库连接测试，会在index控制器调用  进行测试
    public function  test(){
        $sql = "select * from {$this->table}";
        return $this->db->getAll($sql);
    }

    //验证用户是否合法
    public function checkUser($username,$password){
        $password = $password;
        $sql = "select * from {$this->table} where admin_name= '$username' and password = '$password' limit 1";
        return $this->db->getRow($sql);
    }

    //获取指定类型下的属性，并构成表单，商品添加页面的商品属性，通过切换这里来切换内容
    public function getAttrsForm($type_id){

        //获取该类型下所有属性
        $sql = "select * from {$this->table} WHERE  type_id = '$type_id'";
        $attrs = $this->db->getAll($sql);

    }
}