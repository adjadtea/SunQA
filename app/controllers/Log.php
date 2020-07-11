<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package     Question Answer (https://github.com/SunDi3yansyah/SunQA)
 * @author      Cahyadi Triyansyah (http://sundi3yansyah.com)
 * @version     Watch in Latest Tag
 * @license     MIT
 * @copyright   Copyright (c) 2015 SunDi3yansyah
 */

class Log extends CI_Controller{
	public function __construct(){
		parent::__construct();
		
		$this->load->library('session');
		$this->load->model('qa_model_login');
	}
	public function _render($content, $data = NULL){
		$data['head'] = $this->load->view('must/head', $data, TRUE);
		$data['content'] = $this->load->view($content, $data, TRUE);
		$data['foot'] = $this->load->view('must/foot', $data, TRUE);
		$this->load->view('main', $data);
    }
	public function in(){
		if ($this->qa_libs->logged_in()){
			show_404();
			return FALSE;
		}else{
			$this->form_validation->set_rules('username', 'Username', 'trim|required|min_length[3]|max_length[25]|xss_clean');
			$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[200]|xss_clean');
			$this->form_validation->set_error_delimiters('<p>', '</p>');
			if ($this->form_validation->run() == TRUE){
				$this->load->library('phpass');
				$check_username = $this->qa_model_login->login('user', array('username' => $this->input->post('username', TRUE)));
				if ($check_username == TRUE){
					foreach ($check_username as $check_hash){
						$check_password = $this->phpass->check_password($this->input->post('password', TRUE), $check_hash->password);
						if ($check_password == TRUE){
							$looping_user = $this->qa_model_login->looping_login('user', array('username' => $check_hash->username), array('password' => $check_hash->password));
							foreach ($looping_user as $user){
								if ($user->activated === STATUS_NOT_ACTIVATED){
									$data = array(
										'errors' => '<p>Status akun anda belum aktif, silakan periksa alamat email anda.</p>'
										);
									$this->_render('auth/log_in', $data);
								}else{
									$this->session->set_userdata(array(
										'id_user'	=> $user->id_user,
										'username'	=> $user->username,
										'activated'	=> ($user->activated == 1) ? STATUS_ACTIVATED : STATUS_NOT_ACTIVATED,
										'email'		=> $user->email,
										'role_id'	=> $user->role_id,
									));
									$update = array(
										'last_login' => date('Y-m-d H:i:s'),
										'last_ip' => $this->input->ip_address(),
										);
									$this->qa_model->update('user', $update, array('id_user' => $user->id_user));
									redirect($this->session->userdata('current_url'));
								}
							}
						}else{
							$data = array(
								'errors' => '<p>Password yang anda masukkan salah.</p>'
							);
							$this->_render('auth/log_in', $data);
						}					
					}
				}else{
					$data = array(
						'errors' => '<p>Username tidak ada dalam database.</p>'
					);
					$this->_render('auth/log_in', $data);
				}
			}else{
				$this->_render('auth/log_in');
			}			
		}
	}
	public function out(){
		if ($this->qa_libs->logged_in()){
			$this->qa_libs->log_out();
			redirect();
		}else{
			show_404();
			return FALSE;
		}	
	}
}
