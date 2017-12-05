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
        //user表和cz_auth_group, 靠中间表cz_auth_group_id关联起来，用两次join，连表查询

        $sql = "select a.user_id ,a.user_name,a.email,a.status,a.reg_time,a.last_login_time,b.groud_id ,c.title from {$this->table} AS a LEFT JOIN cz_auth_group_id AS b ON a.user_id = b.uid
             LEFT join cz_auth_group AS c ON  b.groud_id = c.id ORDER BY a.user_id DESC ";
        $users = $this->db->getAll($sql);

//        var_dump($users);

        $first = $users[0];
        $first['title'] = array();
        $user_data[$first['user_id']] = $first;

//        var_dump($user_data);

        //组合数组，把id重复的数组过滤掉
        foreach( $users as $key => $value){

            foreach( $user_data as $m => $n){

                $ids = array_map(function($a){ return $a['user_id'];} , $user_data );
                if(!in_array( $value['user_id'],$ids)){

                    $value['title'] = array();
                    $user_data[$value['user_id']] = $value ;
                }
            }
        }
    //    var_dump($user_data);
    //    exit();

        //组合管理员title的数组
        foreach( $user_data as $key => $value){

            foreach( $users as $m =>$n ){

                if( $n['user_id'] == $key){

                    $user_data[$key]['title'][] = $n['title']  ;
                }
            }
            $user_data[$key]['title'] = implode( "、" , $user_data[$key]['title'] );
        }

//            var_dump($user_data);
//            exit();

        return $user_data ;

    }

    //后台获取，单个用户所在的用户组（角色组）， 拼接成数组，以便在编辑页面查看哪些被选中，哪些未被选中
    public function  oneInGroup($id){

        $sql = "select groud_id from cz_auth_group_id WHERE uid = {$id}";
        $groups =  $this->db->getAll($sql);
//        var_dump($groups);
        $group = array_map( function($a){ return $a['groud_id']; } , $groups);
        return $group;
    }




}