<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */

class User extends QA_Publics{
	public function index($str = NULL){
		if (!empty($str)){
			if (!empty($this->_get($str))){
				$data = array(
					'user' => $this->_get($str),
		            'question' => $this->_question($str),
		            'question_tag' => $this->_question_tag($str),
		            'answer' => $this->_answer($str),
		            'comment_question' => $this->_comment_question($str),
		            'comment_answer' => $this->_comment_answer($str),
		            'vote_question' => $this->_vote_question($str),
					'vote_answer' => $this->_vote_answer($str),
				);
				$this->_render('user/get', $data);
			}else{
				show_404();
				return FALSE;
			}
		}else{
			$data = array(
				'user' => $this->qa_model->join('user', 'role', 'user.role_id=role.id_role', 'user.id_user ASC'),
			);
			$this->_render('user/list', $data);
		}
	}
    public function _get($str){
        $var = $this->qa_model->join_where('user', ['table'=>'role','join'=>'user.role_id=role.id_role'], ['username' => $str], 'user.id_user');
        return ($var == FALSE)?array():$var;
    }
    public function _question($str){
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
        $var = $this->qa_model->join_where('question',$arTableJoin,['username' => $str], 'question.id_question DESC');
        return ($var == FALSE)?array():$var;
    }
    public function _question_tag($str){
		$arTableJoin = [
			[
				'table'=>'question',
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
		];
        $var = $this->qa_model->join_where('question_tag',$arTableJoin,['username' => $str], 'question_tag.id_qt');
        return ($var == FALSE)?array():$var;
    }
    public function _answer($str){
		$arTableJoin = [
			[
				'table'=>'user',
				'join'=>'answer.user_id=user.id_user',
			],
			[
				'table'=>'question',
				'join'=>'answer.question_id=question.id_question',
			],
			[
				'table'=>'category',
				'join'=>'question.category_id=category.id_category',
			],
		];
    	$var = $this->qa_model->join_where('answer',$arTableJoin,['username' => $str], 'answer.id_answer DESC');
        return ($var == FALSE)?array():$var;
    }
    public function _comment_question($str){
		$arTableJoin = [
			[
				'table'=>'user',
				'join'=>'comment.user_id=user.id_user',
			],
			[
				'table'=>'question',
				'join'=>'comment.question_id=question.id_question',
			],
		];
    	$var = $this->qa_model->join_where('comment',$arTableJoin,['username' => $str], 'comment.id_comment DESC');
        return ($var == FALSE)?array():$var;
    }
    public function _comment_answer($str){
		$arTableJoin = [
			[
				'table'=>'user',
				'join'=>'comment.user_id=user.id_user',
			],
			[
				'table'=>'answer',
				'join'=>'comment.answer_id=answer.id_answer',
			],
			[
				'table'=>'question',
				'join'=>'answer.question_id=question.id_question',
			],
		];
    	$var = $this->qa_model->join_where('comment',$arTableJoin,['username' => $str], 'comment.id_comment DESC');
        return ($var == FALSE)?array():$var;
    }
    public function _vote_question($str){
		$arTableJoin = [
			[
				'table'=>'user',
				'join'=>'vote.user_id=user.id_user',
			],
			[
				'table'=>'question',
				'join'=>'vote.question_id=question.id_question',
			],
		];
    	$var = $this->qa_model->join_where('vote',$arTableJoin,['username' => $str], 'vote.id_vote DESC');
        return ($var == FALSE)?array():$var;
    }
    public function _vote_answer($str){
		$arTableJoin = [
			[
				'table'=>'user',
				'join'=>'vote.user_id=user.id_user',
			],
			[
				'table'=>'answer',
				'join'=>'vote.answer_id=answer.id_answer',
			],
			[
				'table'=>'question',
				'join'=>'answer.question_id=question.id_question',
			],
		];
    	$var = $this->qa_model->join_where('vote',$arTableJoin,['username' => $str], 'vote.id_vote DESC');
        return ($var == FALSE)?array():$var;
    }
}
