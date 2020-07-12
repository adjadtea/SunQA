<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */

class Tag extends QA_Publics
{
	function index($str = NULL, $ajax = NULL)
	{
		if (!empty($str))
		{
			if (!empty($this->_get($str)))
			{
				$arTableJoin = [
					[
						'table'=>'question_tag',
						'join'=>'question_tag.question_id=question.id_question',
					],
					[
						'table'=>'tag',
						'join'=>'question_tag.tag_id=tag.id_tag',
					],
					[
						'table'=>'user',
						'join'=>'question.user_id=user.id_user',
					],
					[
						'table'=>'category',
						'join'=>'question.category_id=category.id_category',
					],
				];
				foreach ($this->_get($str) as $tag)
				{
					if (!empty($ajax)) {
						$data = array(
							'questions' => $this->qa_model->join_where('question',$arTableJoin,['tag.tag_name' => uri_decode($str)], 'question.id_question', 5, $ajax),
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
					} else {
						$data = array(
							'tag' => $this->_get($str),
							'questions' => $this->qa_model->join_where('question',$arTableJoin,['tag.tag_name' => uri_decode($str)], 'question.id_question', 5, 0),
							);
						if (!empty($data['questions']))
						{
							$this->_render('tag/questions', $data);
						}
						else
						{
							show_404();
							return FALSE;
						}
					}
				}
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
				'tags' => $this->qa_model->all('tag', 'id_tag DESC'),
				);
			if (!empty($data['tags']))
			{
				$this->_render('tag/list', $data);
			}
			else
			{
				$data = array('messages' => 'Belum ada data Tag yang dapat ditampilkan.');
				$this->_render('independent/messages', $data);
			}
		}
	}

    function _get($str)
    {
        $var = $this->qa_model->get_where('tag',['tag_name' => uri_decode($str)]);
        return ($var == FALSE)?array():$var;
    }
}
