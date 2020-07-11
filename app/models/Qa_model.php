<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */
class Qa_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
	}
    public function get_result_array($table, $field){
        $this->db->from($table);
        $this->db->where($field);
        $query = $this->db->get();
        if ($query->num_rows() > 0)
        {
            return $query->result_array();
        }
        else
        {
            return FALSE;
        } 
    }
    public function all($table, $order){
        $this->db->from($table);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function all_where($table, $where, $order){
        $this->db->from($table);
        $this->db->where($where);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0)
        {
            return FALSE;
        }
        else
        {
            return $query->result();
        }
    }
    public function get($table, $where){
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function get_one($table, $where){
        $this->db->from($table);
        $this->db->where($where);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function get_two($table, $where1, $where2){
        $this->db->from($table);
        $this->db->where($where1);
        $this->db->where($where2);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function get_three($table, $where1, $where2, $where3){
        $this->db->from($table);
        $this->db->where($where1);
        $this->db->where($where2);
        $this->db->where($where3);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function firt_or_last($table, $order){
        $this->db->from($table);
        $this->db->limit(1, 0);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0) {
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join($table1, $table2, $join, $order){
        $this->db->from($table1);
        $this->db->join($table2, $join);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join_where($table1, $table2, $join, $where, $order){
        $this->db->from($table1);
        $this->db->join($table2, $join);
        $this->db->where($where);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join_where2($table1, $table2, $join, $where1, $where2, $order){
        $this->db->from($table1);
        $this->db->join($table2, $join);
        $this->db->where($where1);
        $this->db->where($where2);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join_where3($table1, $arTableJoin, $where, $order){
        $this->db->from($table1);
        if(is_array($arTableJoin)){
            foreach($arTableJoin as $vTable){
                $this->db->join($vTable['table'], $vTable['join']);
            }
        }
        $this->db->where($where);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join2($table1, $table2, $table3, $join1, $join2, $order){
        $this->db->from($table1);
        $this->db->join($table2, $join1);
        $this->db->join($table3, $join2);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join3($table1, $arTableJoin, $order){
        $this->db->from($table1);
        if(is_array($arTableJoin)){
            foreach($arTableJoin as $vTable){
                $this->db->join($vTable['table'], $vTable['join']);
            }
        }
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join2_ajax($table1, $table2, $table3, $join1, $join2, $order, $limit, $offset){
        $this->db->from($table1);
        $this->db->join($table2, $join1);
        $this->db->join($table3, $join2);
        $this->db->limit($limit, $offset);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join2_where_ajax($table1, $table2, $table3, $join1, $join2, $where, $order, $limit, $offset){
        $this->db->from($table1);
        $this->db->join($table2, $join1);
        $this->db->join($table3, $join2);
        $this->db->limit($limit, $offset);
        $this->db->where($where);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join3_where_ajax($table1, $arTableJoin, $where=[], $order, $limit, $offset){
        $this->db->from($table1);
        if(is_array($arTableJoin)){
            foreach($arTableJoin as $vTable){
                $this->db->join($vTable['table'], $vTable['join']);
            }
        }
        $this->db->limit($limit, $offset);
        if(is_array($where)){
            for($i=0;$i<count($where);$i++){
                if(is_array($where[$i])) $this->db->where($where[$i]);
            }
        }
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    function join2_where($table1, $table2, $table3, $join1, $join2, $where, $order){
        $this->db->from($table1);
        $this->db->join($table2, $join1);
        $this->db->join($table3, $join2);
        $this->db->where($where);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join2_where2($table1, $table2, $table3, $join1, $join2, $where1, $where2, $order){
        $this->db->from($table1);
        $this->db->join($table2, $join1);
        $this->db->join($table3, $join2);
        $this->db->where($where1);
        $this->db->where($where2);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function join3_where($table1, $table2, $table3, $table4, $join1, $join2, $join3, $where, $order){
        $this->db->from($table1);
        $this->db->join($table2, $join1);
        $this->db->join($table3, $join2);
        $this->db->join($table4, $join3);
        $this->db->where($where);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function _join($table,$arTableJoin=[],$arWhere=[],$order='',$limit=0,$offset=0){
        $this->db->from($table);
        if(is_array($arTableJoin)){
            if(count($arTableJoin)>0){
                foreach($arTableJoin as $vTable){
                    $this->db->join($vTable['table'],$vTable['join']);
                }
            }
        }
    }
    function join4_where_ajax($table1, $table2, $table3, $table4, $table5, $join1, $join2, $join3, $join4, $where, $order, $limit, $offset){
        $this->db->from($table1);
        $this->db->join($table2, $join1);
        $this->db->join($table3, $join2);
        $this->db->join($table4, $join3);
        $this->db->join($table5, $join4);
        $this->db->limit($limit, $offset);
        $this->db->where($where);
        $this->db->order_by($order);
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function insert($table, $data){
        if ($this->db->insert($table, $data)){
            $this->db->insert_id();
            return $this->db->affected_rows();
        }else{
            return FALSE;
        }
    }
    public function update($table, $data, $where){
        $this->db->update($table, $data, $where);
        return $this->db->affected_rows();
    }
    public function delete($table, $where){
        $this->db->delete($table, $where);
        return $this->db->affected_rows();
    }
    public function count($table){
        $this->db->from($table);
        $count = $this->db->count_all_results();
        if ($count == 0){
            return 0;
        }else{
            return $count;
        }
    }
    public function count_where($table, $where){
        $this->db->from($table);
        $this->db->where($where);
        $count = $this->db->count_all_results();
        if ($count == 0){
            return 0;
        }else{
            return $count;
        }
    }
    public function count_where2($table, $where1, $where2){
        $this->db->from($table);
        $this->db->where($where1);
        $this->db->where($where2);
        $count = $this->db->count_all_results();
        if ($count == 0){
            return 0;
        }else{
            return $count;
        }
    }
    public function count_join_where($table1, $table2, $join, $where){
        $this->db->from($table1);
        $this->db->join($table2, $join);
        $this->db->where($where);
        $count = $this->db->count_all_results();
        if ($count == 0){
            return 0;
        }else{
            return $count;
        }
    }
    public function viewers($table, $field, $where){
        $this->db->from($table);
        $this->db->set($field, "$field+1", FALSE);
        $this->db->where($where);
        $query = $this->db->update();
        if ($query == 0){
            return FALSE;
        }else{
            return $query;
        }
    }
}
