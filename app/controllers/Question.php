<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */

class Question extends QA_Publics
{
	function a302344c485385d66b3c1736be5213fb07e7fbb8($str = NULL, $action = NULL, $num = NULL)
	{
		if (!empty($str))
		{
			$data = array(
				'question' => $this->_get($str),
				'question_tag' => $this->_question_tag($str),
				);
			if (!empty($data['question']))
			{
				if (!empty($str) && empty($action))
				{
					foreach ($data['question'] as $question)
					{
						$arTableJoinAnswer = [
							['table'=>'user','join'=>'answer.user_id=user.id_user'],
							['table'=>'question','join'=>'answer.question_id=question.id_question'],
						];
						$arTableJoinCommentQuestion = [
							['table'=>'user','join'=>'comment.user_id=user.id_user'],
							['table'=>'question','join'=>'comment.question_id=question.id_question'],
						];
						$data['answer'] = $this->qa_model->join_where('answer',$arTableJoinAnswer,['answer.question_id' => $question->id_question], 'answer.id_answer');
						$data['comment_in_question'] = $this->qa_model->join_where('comment',$arTableJoinCommentQuestion,['comment.question_id' => $question->id_question], 'comment.id_comment');
						$data['count_vote'] = $this->qa_model->count_where('vote', ['question_id' => $question->id_question,'vote_for' => 'Up']) - $this->qa_model->count_where('vote', ['question_id' => $question->id_question, 'vote_for' => 'Down']);
						$this->qa_model->viewers('question', 'viewers', array('id_question' => $question->id_question));
						if ($this->qa_libs->logged_in())
						{
							if ($question->user_id != $this->qa_libs->id_user())
							{
								$this->form_validation->set_rules('description_answer', 'Description', 'trim|required|xss_clean');
								$this->form_validation->set_error_delimiters('<p>', '</p>');
								if ($this->form_validation->run() == TRUE)
								{
									$insert = array(
										'user_id' => $this->qa_libs->id_user(),
										'question_id' => $question->id_question,
										'description_answer' => $this->input->post('description_answer', TRUE),
										'answer_date' => date('Y-m-d H:i:s'),
										);
									$this->qa_model->insert('answer', $insert);
									redirect($this->uri->segment(1) .'/'. $question->url_question);
								}
								else
								{
									$this->_render('question/get', $data);
								}
							}
							else
							{
								$this->_render('question/get', $data);
							}
						}
						else
						{
							$this->_render('question/get', $data);
						}
					}
				}
				elseif (!empty($str && $action) && empty($num))
				{
					if ($this->qa_libs->logged_in())
					{
						if ($action === 'update')
						{
							foreach ($data['question'] as $question)
							{
								if ($question->user_id != $this->qa_libs->id_user())
								{
									show_404();
									return FALSE;
								}
								else
								{
									$this->form_validation->set_rules('subject', 'Description', 'trim|required|xss_clean');
									$this->form_validation->set_rules('category_id', 'Description', 'trim|required|xss_clean');
									$this->form_validation->set_rules('description_question', 'Description', 'trim|required|xss_clean');
									$this->form_validation->set_error_delimiters('<p>', '</p>');
									if ($this->form_validation->run() == TRUE)
									{
											$update = array(
												'subject' => $this->input->post('subject', TRUE),
												'category_id' => $this->input->post('category_id', TRUE),
												'description_question' => $this->input->post('description_question', TRUE),
												'question_update' => date('Y-m-d H:i:s'),
												'url_question' => qa_url($question->id_question, $this->input->post('subject', TRUE)),
												);
											$this->qa_model->update('question', $update, array('id_question' => $question->id_question));
											$this->qa_model->delete('question_tag', array('question_id' => $question->id_question));
											$loop_question = $this->qa_model->get_where('question',['id_question' => $question->id_question]);
											foreach ($loop_question as $lq) {
												foreach ($this->input->post('id_tag', TRUE) as $tag)
												{
													$tags = array(
														'question_id' => $lq->id_question,
														'tag_id' => $tag,
														);
													$this->qa_model->insert('question_tag', $tags);
												}
											}
											redirect($this->uri->segment(1) .'/'. $update['url_question']);
									}
									else
									{
										$data['category'] = $this->qa_model->all('category', 'id_category ASC');
										$data['tag'] = $this->qa_model->all('tag', 'id_tag ASC');
										$this->_render('question/update', $data);
									}
								}
							}
						}
						elseif ($action === 'delete')
						{
							foreach ($data['question'] as $question)
							{
								if ($question->user_id != $this->qa_libs->id_user())
								{
									show_404();
									return FALSE;
								}
								else
								{
									$this->qa_model->delete('question', array('url_question' => $str));
									redirect();
								}
							}
						}
						elseif ($action === 'vq_up')
						{
							foreach ($data['question'] as $question)
							{
								if ($question->user_id != $this->qa_libs->id_user())
								{
									$check_exist = $this->qa_model->get_where('vote',[
										'user_id' => $this->qa_libs->id_user(),
										'question_id' => $question->id_question
									]);
									if ($check_exist == TRUE)
									{
										foreach ($check_exist as $vote)
										{
											if ($vote->vote_for == 'Down')
											{
												$update_vote = array(
													'vote_update' => date('Y-m-d H:i:s'),
													'vote_for' => 'Up',
													);
												$this->qa_model->update('vote', $update_vote, array('id_vote' => $vote->id_vote));
												redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
											}
											else
											{
												$data = array('messages' => 'Anda sudah memberikan Vote UP pada pertanyaan ini.');
												$this->_render('independent/messages', $data);
											}
										}
									}
									else
									{
										$vote = array(
											'user_id' => $this->qa_libs->id_user(),
											'question_id' => $question->id_question,
											'vote_in' => 'Question',
											'vote_date' => date('Y-m-d H:i:s'),
											'vote_for' => 'Up',
											);
										$this->qa_model->insert('vote', $vote);
										redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
									}
								}
								else
								{
									$data = array('messages' => 'Permission denied!');
									$this->_render('independent/messages', $data);
								}
							}
						}
						elseif ($action === 'vq_down')
						{
							foreach ($data['question'] as $question)
							{
								if ($question->user_id != $this->qa_libs->id_user())
								{
									$arWhere = [
										'user_id' => $this->qa_libs->id_user(),
										'question_id' => $question->id_question
									];
									$check_exist = $this->qa_model->get_where('vote', $arWhere);
									if ($check_exist == TRUE)
									{
										foreach ($check_exist as $vote)
										{
											if ($vote->vote_for == 'Up')
											{
												$update_vote = array(
													'vote_update' => date('Y-m-d H:i:s'),
													'vote_for' => 'Down',
													);
												$this->qa_model->update('vote', $update_vote, array('id_vote' => $vote->id_vote));
												redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
											}
											else
											{
												$data = array('messages' => 'Anda sudah memberikan Vote DOWN pada pertanyaan ini.');
												$this->_render('independent/messages', $data);
											}
										}
									}
									else
									{
										$vote = array(
											'user_id' => $this->qa_libs->id_user(),
											'question_id' => $question->id_question,
											'vote_in' => 'Question',
											'vote_date' => date('Y-m-d H:i:s'),
											'vote_for' => 'Down',
											);
										$this->qa_model->insert('vote', $vote);
										redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
									}
								}
								else
								{
									$data = array('messages' => 'Permission denied!');
									$this->_render('independent/messages', $data);
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
						show_404();
						return FALSE;
					}
				}
				elseif (!empty($str && $action && $num))
				{
					if ($this->qa_libs->logged_in())
					{
						if ($action === 'answer')
						{
							foreach ($data['question'] as $question)
							{
								if ($question->user_id === $this->qa_libs->id_user())
								{
									$check_exist = $this->qa_model->get_where('answer',[
										'id_answer' => $num,
										'question_id' => $question->id_question
									]);
									if (!empty($check_exist))
									{
										$update_question = array(
											'answer_id' => $num
											);
										$this->qa_model->update('question', $update_question, array('id_question' => $question->id_question));
										redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
									}
									else
									{
										show_404();
										return FALSE;
									}
								}
								else
								{
									show_404();
									return FALSE;
								}
							}
						}
						elseif ($action === 'va_up')
						{
							foreach ($data['question'] as $question)
							{
								$answer = $this->qa_model->get_where('answer', [
									'id_answer' => $num,
									'question_id' => $question->id_question
								]);
								if ($answer != FALSE)
								{
									foreach ($answer as $ans)
									{
										if ($ans->user_id != $this->qa_libs->id_user())
										{
											$check_exist = $this->qa_model->get_where('vote', [
												'user_id' => $this->qa_libs->id_user(),
												'answer_id' => $num
											]);
											if ($check_exist == TRUE)
											{
												foreach ($check_exist as $vote)
												{
													if ($vote->vote_for == 'Down')
													{
														$update_vote = array(
															'vote_update' => date('Y-m-d H:i:s'),
															'vote_for' => 'Up',
															);
														$this->qa_model->update('vote', $update_vote, array('id_vote' => $vote->id_vote));
														redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
													}
													else
													{
														$data = array('messages' => 'Anda sudah memberikan Vote UP pada pertanyaan ini.');
														$this->_render('independent/messages', $data);
													}
												}
											}
											else
											{
												$vote = array(
													'user_id' => $this->qa_libs->id_user(),
													'answer_id' => $num,
													'vote_in' => 'Answer',
													'vote_date' => date('Y-m-d H:i:s'),
													'vote_for' => 'Up',
													);
												$this->qa_model->insert('vote', $vote);
												redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
											}
										}
										else
										{
											$data = array('messages' => 'Permission denied!');
											$this->_render('independent/messages', $data);
										}									
									}
								}
								else
								{
									show_404();
									return FALSE;
								}
							}
						}
						elseif ($action === 'va_down')
						{
							foreach ($data['question'] as $question)
							{
								$answer = $this->qa_model->get_where('answer', [
									'id_answer' => $num,
									'question_id' => $question->id_question
								]);
								if ($answer != FALSE)
								{
									foreach ($answer as $ans)
									{
										if ($ans->user_id != $this->qa_libs->id_user())
										{
											$check_exist = $this->qa_model->get_where('vote', [
												'user_id' => $this->qa_libs->id_user(),
												'answer_id' => $num
											]);
											if ($check_exist == TRUE)
											{
												foreach ($check_exist as $vote)
												{
													if ($vote->vote_for == 'Up')
													{
														$update_vote = array(
															'vote_update' => date('Y-m-d H:i:s'),
															'vote_for' => 'Down',
															);
														$this->qa_model->update('vote', $update_vote, array('id_vote' => $vote->id_vote));
														redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
													}
													else
													{
														$data = array('messages' => 'Anda sudah memberikan Vote DOWN pada pertanyaan ini.');
														$this->_render('independent/messages', $data);
													}
												}
											}
											else
											{
												$vote = array(
													'user_id' => $this->qa_libs->id_user(),
													'answer_id' => $num,
													'vote_in' => 'Answer',
													'vote_date' => date('Y-m-d H:i:s'),
													'vote_for' => 'Down',
													);
												$this->qa_model->insert('vote', $vote);
												redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
											}
										}
										else
										{
											$data = array('messages' => 'Permission denied!');
											$this->_render('independent/messages', $data);
										}
									}
								}
								else
								{
									show_404();
									return FALSE;
								}
							}
						}
						elseif ($action === 'cq')
						{
							$data['comment_question'] = $this->qa_model->join_where('question',['table'=>'user','join'=>'question.user_id=user.id_user'], ['id_question' => $num], 'question.id_question');
							if (!empty($data['comment_question']))
							{
								$this->form_validation->set_rules('description_comment', 'Description', 'trim|required|xss_clean');
								$this->form_validation->set_error_delimiters('<p>', '</p>');
								if ($this->form_validation->run() == TRUE)
								{
									$cq = array(
										'user_id' => $this->qa_libs->id_user(),
										'question_id' => $num,
										'comment_in' => 'Question',
										'description_comment' => $this->input->post('description_comment', TRUE),
										'comment_date' => date('Y-m-d H:i:s'),
										);
									$this->qa_model->insert('comment', $cq);
									redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
								}
								else
								{
									$this->_render('question/comment_question', $data);
								}
							}
							else
							{
								show_404();
								return FALSE;
							}
						}
						elseif ($action === 'ca')
						{
							$arTableJoin = [
								['table'=>'user','join'=>'answer.user_id=user.id_user'],
								['table'=>'question','join'=>'answer.question_id=question.id_question'],
							];
							$data['comment_answer'] = $this->qa_model->join_where('answer', $arTableJoin, ['id_answer' => $num], 'answer.id_answer');
							if (!empty($data['comment_answer']))
							{
								$this->form_validation->set_rules('description_comment', 'Description', 'trim|required|xss_clean');
								$this->form_validation->set_error_delimiters('<p>', '</p>');
								if ($this->form_validation->run() == TRUE)
								{
									$ca = array(
										'user_id' => $this->qa_libs->id_user(),
										'answer_id' => $num,
										'comment_in' => 'Answer',
										'description_comment' => $this->input->post('description_comment', TRUE),
										'comment_date' => date('Y-m-d H:i:s'),
										);
									$this->qa_model->insert('comment', $ca);
									redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
								}
								else
								{
									$this->_render('question/comment_answer', $data);
								}
							}
							else
							{
								show_404();
								return FALSE;
							}
						}
						elseif ($action === 'ua')
						{
							$arTableJoin = [
								['table'=>'user','join'=>'answer.user_id=user.id_user'],
								['table'=>'question','join'=>'answer.question_id=question.id_question'],
							];
							$data['update_answer'] = $this->qa_model->join_where('answer',$arTableJoin,['id_answer' => $num,'answer.user_id' => $this->qa_libs->id_user()], 'answer.id_answer');
							if (!empty($data['update_answer']))
							{
								$this->form_validation->set_rules('description_answer', 'Description', 'trim|required|xss_clean');
								$this->form_validation->set_error_delimiters('<p>', '</p>');
								if ($this->form_validation->run() == TRUE)
								{
									$ua = array(
										'description_answer' => $this->input->post('description_answer', TRUE),
										'answer_update' => date('Y-m-d H:i:s'),
										);
									$this->qa_model->update('answer', $ua, array('id_answer' => $num));
									redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
								}
								else
								{
									$this->_render('question/update_answer', $data);
								}
							}
							else
							{
								show_404();
								return FALSE;
							}
						}
						elseif ($action === 'uc')
						{
							$data['update_comment'] = $this->qa_model->join_where('comment',['table'=>'user','join'=>'comment.user_id=user.id_user'], ['id_comment' => $num,'comment.user_id' => $this->qa_libs->id_user()], 'comment.id_comment');
							if (!empty($data['update_comment']))
							{
								$this->form_validation->set_rules('description_comment', 'Description', 'trim|required|xss_clean');
								$this->form_validation->set_error_delimiters('<p>', '</p>');
								if ($this->form_validation->run() == TRUE)
								{
									$uc = array(
										'description_comment' => $this->input->post('description_comment', TRUE),
										'comment_update' => date('Y-m-d H:i:s'),
										);
									$this->qa_model->update('comment', $uc, array('id_comment' => $num));
									redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
								}
								else
								{
									$this->_render('question/update_comment', $data);
								}
							}
							else
							{
								show_404();
								return FALSE;
							}
						}
						elseif ($action === 'da')
						{
							$arTableJoin = [
								['table'=>'user','join'=>'answer.user_id=user.id_user'],
								['table'=>'question','join'=>'answer.question_id=question.id_question'],
							];
							$data['delete_answer'] = $this->qa_model->join_where('answer',$arTableJoin, ['id_answer' => $num,'answer.user_id' => $this->qa_libs->id_user()], 'answer.id_answer');
							if (!empty($data['delete_answer']))
							{
								$this->qa_model->delete('answer', array('id_answer' => $num));
								redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
							}
							else
							{
								show_404();
								return FALSE;
							}
						}
						elseif ($action === 'dc')
						{
							$data['delete_comment'] = $this->qa_model->join_where('comment', ['table'=>'user','join'=>'comment.user_id=user.id_user'], ['id_comment' => $num, 'comment.user_id' => $this->qa_libs->id_user()], 'comment.id_comment');
							if (!empty($data['delete_comment']))
							{
								$this->qa_model->delete('comment', array('id_comment' => $num));
								redirect($this->uri->segment(1) .'/'. $this->uri->segment(2));
							}
							else
							{
								show_404();
								return FALSE;
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
						show_404();
						return FALSE;
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
				show_404();
				return FALSE;
			}
		}
		else
		{
			show_404();
			return FALSE;
		}		
	}

	function _get($str)
	{
		$arTableJoin = [
			['table'=>'user','join'=>'question.user_id=user.id_user'],
			['table'=>'category','join'=>'question.category_id=category.id_category'],
		];
        $var = $this->qa_model->join_where('question', $arTableJoin, '',['url_question' => $str], 'question.id_question DESC');
        return ($var == FALSE)?array():$var;
	}

    function _question_tag($str)
    {
		$arTableJoin = [
			['table'=>'question','join'=>'question_tag.question_id=question.id_question'],
			['table'=>'tag','join'=>'question_tag.tag_id=tag.id_tag'],
		];
        $var = $this->qa_model->join_where('question_tag',$arTableJoin, ['url_question' => $str], 'question_tag.id_qt');
        return ($var == FALSE)?array():$var;
    }
}
