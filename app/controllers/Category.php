<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */

class Category extends QA_Publics
{
	public function __construct(){
		parent::__construct();
	}
	public function index($str = NULL, $ajax = NULL){
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
		if (!empty($str)){
			if (!empty($this->_get($str))){
				foreach ($this->_get($str) as $cat){
					if (!empty($ajax)) {
						$data = array(
							'questions' => $this->qa_model->join_where('question',$arTableJoin, array('category_id' => $cat->id_category), 'question.id_question DESC', 5, $ajax),
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
					} else {
						$data = array(
							'category' => $this->_get($str),
							'questions' => $this->qa_model->join_where('question',$arTableJoin, array('category_id' => $cat->id_category), 'question.id_question DESC', 5, 0),
							'question_tag' => $this->_question_tag(),
							);
						if (!empty($data['questions']))
						{
							$this->_render('category/questions', $data);
						}
						else
						{
							show_404();
							return FALSE;
						}
					}
				}
			}else{
				show_404();
				return FALSE;
			}
		}
		else
		{
			$data = array(
				'categories' => $this->qa_model->all('category', 'id_category DESC'),
				);
			if (!empty($data['categories'])){
				$this->_render('category/list', $data);
			}else{
				$data = array('messages' => 'Belum ada data Category yang dapat ditampilkan.');
				$this->_render('independent/messages', $data);
			}
		}
	}
    public function _get($str){
        $var = $this->qa_model->get('category', array('category_name' => uri_decode($str)));
        return ($var == FALSE)?array():$var;
    }
    public function _question_tag(){
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
        $var = $this->qa_model->join_where('question_tag', $arTableJoin,null,'question_tag.id_qt');
        return ($var == FALSE)?array():$var;
    }
}
