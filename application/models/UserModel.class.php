<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/12/3
 * Time: 9:56
 */
class UserModel extends Model{

    //后台获取所有的用户信息,同时的关联用户-用户组的关联表，关联后，对于组别多条记录还得拼在一起
    public function  getUsers(){

//        $sql = "select * from {$this->table}";
//        $users =  $this->db->getAll($sql);
//        return $users;

        $sql = "select a.user_id ,a.user_name,a.email,a.status,a.reg_time,a.last_login_time,b.groud_id from {$this->table} AS a JOIN cz_auth_group_id AS b ON a.user_id = b.uid ";
        $users = $this->db->getAll($sql);
        return $users;
    }

}