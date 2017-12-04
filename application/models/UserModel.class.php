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
        //user表和关联表，连表查询

        $sql = "select a.user_id ,a.user_name,a.email,a.status,a.reg_time,a.last_login_time,b.groud_id from {$this->table} AS a JOIN cz_auth_group_id AS b ON a.user_id = b.uid ";
        $users = $this->db->getAll($sql);

        $first = $users[0];
        $first['title'] = array();
        $user_data[$first['id']] = $first;

        //组合数组，把id重复的数组过滤掉
        foreach( $users as $key => $value){

            foreach( $user_data as $m => $n){

                $ids = array_map(function($a){ return $a['id'];} , $user_data );
                if(!in_array( $value['id'],$ids)){

                    $value['title'] = array();
                    $user_data[$value['id']] = $value ;
                }
            }
        }

        //组合管理员title的数组
        foreach( $user_data as $key => $value){

            foreach( $users as $m =>$n ){

                if( $n['id'] == $key){

                    $user_data[$key]['title'][] = $n['title']  ;
                }
            }
            $user_data[$key]['title'] = implode( "、" , $user_data[$key]['title'] );
        }

        return $user_data ;

//        return $users;
    }

}