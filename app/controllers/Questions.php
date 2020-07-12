<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */

class Questions extends QA_Publics
{
	function index($str = NULL)
	{
		$arTableJoin = [
			[
				'table'=>'user',
				'join'=>'question.user_id=user.id_user',
			],
			[
				'table'=>'category',
				'join'=>'question.category_id=category.id_category',
			],
		];
		if (!empty($str))
		{
			$data = array(
				'questions' => $this->qa_model->join_where('question', $arTableJoin,null, 'question.id_question DESC', 5, $str),
				'question_tag' => $this->_question_tag(),
				);
			if (!empty($data['questions']))
			{
				$this->load->view('questions/questions_ajax', $data);
			}
			else
			{
				show_404();
				return FALSE;
			}
		}
		else
		{
			$data = array(
				'questions' => $this->qa_model->join_where('question', 'user', 'category', 'question.user_id=user.id_user', 'question.category_id=category.id_category', 'question.id_question DESC', 5, 0),
				'question_tag' => $this->_question_tag(),
				);
			if (!empty($data['questions']))
			{
				$this->_render('questions/questions', $data);
			}
			else
			{
				$data = array('messages' => 'Belum ada data yang dapat ditampilkan.');
				$this->_render('independent/messages', $data);
			}
		}
	}

	function unanswereds($str = NULL)
	{
		$arTableJoin = [
			[
				'table'=>'user',
				'join'=>'question.user_id=user.id_user',
			],
			[
				'table'=>'category',
				'join'=>'question.category_id=category.id_category',
			],
		];
		if (!empty($str)) {
			$data = array(
				'questions' => $this->qa_model->join_where('question',$arTableJoin, ['answer_id' => NULL], 'question.id_question DESC', 5, $str),
				'question_tag' => $this->_question_tag(),
				);
			if (!empty($data['questions']))
			{
				$this->load->view('questions/unanswereds_ajax', $data);
			}
			else
			{
				show_404();
				return FALSE;
			}
		} else {
			$data = array(
				'questions' => $this->qa_model->join_where('question', $arTableJoin,['answer_id' => NULL], 'question.id_question DESC', 5, 0),
				'question_tag' => $this->_question_tag(),
				);
			if (!empty($data['questions']))
			{
				$this->_render('questions/unanswereds', $data);
			}
			else
			{
				$data = array('messages' => 'Belum ada data yang dapat ditampilkan.');
				$this->_render('independent/messages', $data);
			}
		}
	}

	function most_view($str = NULL)
	{
		$arTableJoin = [
			[
				'table'=>'user',
				'join'=>'question.user_id=user.id_user',
			],
			[
				'table'=>'category',
				'join'=>'question.category_id=category.id_category',
			],
		];
		if (!empty($str)) {
			$data = array(
				'questions' => $this->qa_model->join_where('question',$arTableJoin,null,'question.viewers DESC', 5, $str),
				'question_tag' => $this->_question_tag(),
			);
			if (!empty($data['questions']))
			{
				$this->load->view('questions/most_view_ajax', $data);
			}
			else
			{
				show_404();
				return FALSE;
			}
		} else {
			$data = array(
				'questions' => $this->qa_model->join_where('question',$arTableJoin,null,'question.viewers DESC', 5, 0),
				'question_tag' => $this->_question_tag(),
			);
			if (!empty($data['questions']))
			{
				$this->_render('questions/most_view', $data);
			}
			else
			{
				$data = array('messages' => 'Belum ada data yang dapat ditampilkan.');
				$this->_render('independent/messages', $data);
			}
		}
	}

    function _question_tag()
    {
		$arTableJoin = [
			[
				'table'=>'question',
				'join'=>'question_tag.question_id=question.id_question',
			],
			[
				'table'=>'tag',
				'join'=>'question_tag.tag_id=tag.id_tag',
			],
		];
        $var = $this->qa_model->join_where('question_tag',$arTableJoin, null,'question_tag.id_qt');
        return ($var == FALSE)?array():$var;
    }
}
