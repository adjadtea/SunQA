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
    public function get_where($table,$arWhere=null){
        $this->db->from($table);
        if(is_array($arWhere)) $this->db->where($arWhere);
        elseif(trim($arWhere)) $this->db->where($arWhere);
        else{}
        $query = $this->db->get();
        if ($query->num_rows() == 0){
            return FALSE;
        }else{
            return $query->result();
        }
    }
    public function firt_or_last($table, $order='asc'){
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
    public function join_where($table1, $arTableJoin=null, $arWhere=null, $order=null,$limit=0,$offset=0){
        $this->db->from($table1);
        if(is_array($arTableJoin)){
            foreach($arTableJoin as $vTable){
                $this->db->join($vTable['table'], $vTable['join']);
            }
        }elseif(trim($arTableJoin)!='') $this->db->join($arTableJoin);
        else{}
        if(is_array($arWhere)){
            $this->db->where($arWhere);
        }elseif(trim($arWhere)!='') $this->db->where($arWhere);
        else{}
        if(trim($order)!='') $this->db->order_by($order);
        if($limit>0) $this->db->limit($limit, $offset);
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
    public function insert($table, $data){
        if ($this->db->insert($table, $data)){
            return $this->db->insert_id();
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
    public function count_where($table, $arWhere=null){
        $this->db->from($table);
        if(is_array($arWhere)){
            $this->db->where($arWhere);
        }elseif(trim($arWhere)) $this->db->where($arWhere);
        else{}
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
