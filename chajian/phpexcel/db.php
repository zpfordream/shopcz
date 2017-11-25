<?php
/**
 * Created by PhpStorm.
 * User: ZP
 * Date: 2017/11/25
 * Time: 10:53
 */


class db{

    public  $conn = null ;


    public function __construct($config)
    {
        $this->conn = mysqli_connect($config['host'],$config['user'],$config['password'],$config['dbname']);
        if(!$this->conn){
            printf("Can't connect to MySQL Server. Errorcode: %s ", mysqli_connect_error());
            exit;
        }else{
            echo '数据库连接上了！';
        }
    }


    //传入sql语句查询内容
    function  getResult($sql){

        $resource = mysqli_query($this->conn, $sql);
        $res = array();
        while( $row = mysqli_fetch_assoc($resource) ){
            $res[] = $row ;
        }
        return $res;
    }

    //传入年级数，展示每个年级的信息
    public function getDataByGrade($grade){

        $sql = "SELECT username,score ,class from phpexcel_test where grade = {$grade} ORDER BY score DESC ";
        $res = self::getResult($sql);

        return $res;
    }

    //查询所有年级,distinct(grade)  z这个是去重，通过grade字段去重，把不重复的显示出来，显示方式和普通的输出一样
    public function getAllGrade(){
        $sql = " select distinct(grade) from phpexcel_test ORDER BY grade ASC ";
        $res = $this->getResult($sql);
        return $res;
    }

    //根据年级查询所有班级
    public  function getClassByGrade($grade){
        $sql=" select distinct(class) from phpexcel_test WHERE  grade = {$grade} ORDER BY class ASC ";
        $res = $this -> getResult($sql);
        return $res;
    }

    //根据班级，年级查出学生信息
    public function getDataByClassGrade($class ,$grade){
        $sql = "select * from phpexcel_test WHERE class = {$class} and grade = {$grade} ORDER BY  score DESC ";
        $res = $this->getResult($sql);
        return $res;
    }



}

