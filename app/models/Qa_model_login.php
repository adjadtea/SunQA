<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */
class Qa_model_login extends CI_Model
{
	function __construct()
	{
		parent::__construct();
	}

    function login($table, $where)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1)
        {
            return $query->result();
        }
        else
        {
            return FALSE;
        }
    }

    function looping_login($table, $where1, $where2)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($where1);
        $this->db->where($where2);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1)
        {
            return $query->result();
        }
        else
        {
            return FALSE;
        }
    }
}