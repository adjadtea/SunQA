<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */

class Home extends QA_Publics{
	public function __construct(){
		parent::__construct();
	}
	public function index(){
		$data = array(
			'latest_question' => $this->_latest_question(),
			'question_tag' => $this->_question_tag(),
			);
		$this->_render('independent/home', $data);
	}
	public function _latest_question(){
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
        $var = $this->qa_model->join3_where_ajax('question', $arTableJoin, 'question.id_question DESC', 5, 0);
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
        $var = $this->qa_model->join3('question_tag', $arTableJoin, 'question_tag.id_qt');
        return ($var == FALSE)?array():$var;
    }
}
