<?php
/**
 * Created by PhpStorm.
 * User: 益彩通
 * Date: 2017-11-09
 * Time: 13:53
 */

class  AttributeModel extends Model{

    //获取传入类型的所有的商品属性， 需要连表查询
    public  function  getAttrs ($type_id){

      //  $sql = "SELECT * FROM {$this->table} WHERE type_id = '$type_id' ";

        $sql = "SELECT a.*,b.type_name FROM cz_attribute as a INNER JOIN cz_goods_type AS b ON a.type_id = b.type_id WHERE a.type_id = '$type_id'";
        return $this->db->getAll($sql);
    }


    //获取分页的属性列表
    public function getPageAttrs( $type_id ,$offset, $pagesize  ){
        $sql = "SELECT a.*,b.type_name FROM cz_attribute as a INNER JOIN cz_goods_type AS b ON a.type_id = b.type_id WHERE a.type_id = '$type_id' limit $offset,$pagesize";
        return   $this->db->getAll($sql);

    }


    //获取指定类型下的属性，并构成表单，即用php在html页面的输出属性列表
    public function getAttrsForm( $type_id   ){
        $sql = "SELECT * from {$this->table} WHERE  type_id = $type_id";
        $attrs =  $this->db->getAll($sql);

        $res = "<table width='100%' id='attrTable'>";
        $res .="<tbody>";
        foreach( $attrs as $attr ){
            $res .= "<tr>";
            $res .= "<td class='label'>{$attr['attr_name']}</td>";
            $res .= "<td>";
            $res .= "<input type='hidden'  name='attr_id_list[]' value='".$attr['attr_id']."'>";

            //根据attr_input_type值不同，生成不同的表单
            switch($attr['attr_input_type']){
                case 0: #文本框
                    $res .= "<input name='attr_value_list[]' type='text' value='' size='40' >" ;
                    break;
                case 1: #下拉列表
                    $res .= "<select name='attr_value_list[]'>" ;
                    $res .= "<option value=''>请选择...</option>" ;
                    $opts = explode(PHP_EOL , $attr['attr_value']);
                    foreach($opts as $opt){
                        $res .= "<option value='$opt'>$opt</option>" ;
                    }
                    $res .= "</select>" ;
                    break;
                case 2: #多行文本
                    $res .= "<textarea type='hidden' name='attr_value_list[]' value='0'> " ;
                    break;
            }

            $res .="<input type='hidden' name='attr_price_list[]' value='0'>";
            $res .="</td>";
            $res .="</tr>";

        }
        $res .= "</tbody>";
        $res .= "</table>";
        return $res;

    }

/*
<table width="100%" id="attrTable">
<tbody>
<tr>
<td class="label">上市日期</td>
<td>
<input type="hidden" name="attr_id_list[]" value="172">
<select name="attr_value_list[]">
<option value="">请选择...</option>
<option value="2008年01月">2008年01月</option>
</select>
<input type="hidden" name="attr_price_list[]" value="0">
</td>
</tr>
<tr>
<td class="label">操作系统</td>
<td>
<input type="hidden" name="attr_id_list[]" value="182">
<input name="attr_value_list[]" type="text" value="Symbian OS v9.3" size="40">
<input type="hidden" name="attr_price_list[]" value="0">
</td>
</tr>
<tr>
<td class="label">K-JAVA</td>
<td>
<input type="hidden" name="attr_id_list[]" value="183">
<input name="attr_value_list[]" type="text" value="" size="40">
<input type="hidden" name="attr_price_list[]" value="0">
</td>
</tr>
<tr>
<td class="label">尺寸体积</td>
<td><input type="hidden" name="attr_id_list[]" value="184">
<input name="attr_value_list[]" type="text" value="" size="40">
<input type="hidden" name="attr_price_list[]" value="0">
</td>
</tr>
<tr>
<td class="label">屏幕颜色</td>
<td>
<input type="hidden" name="attr_id_list[]" value="186">
<select name="attr_value_list[]">
<option value="">请选择...</option>
<option value="1600万">1600万</option>
<option value="262144万">262144万</option>
</select>
<input type="hidden" name="attr_price_list[]" value="0">
</td>
</tr>

<tr>
<td class="label">理论通话时间</td>
<td>
<input type="hidden" name="attr_id_list[]" value="174">
<input name="attr_value_list[]" type="text" value="6.9 小时" size="40">
<input type="hidden" name="attr_price_list[]" value="0">
</td>
</tr>
<tr>
<td class="label">理论待机时间</td>
<td>
<input type="hidden" name="attr_id_list[]" value="175">
<input name="attr_value_list[]" type="text" value="363 小时" size="40">
<input type="hidden" name="attr_price_list[]" value="0">
</td>
</tr>

</tbody>
</table>
*/








}