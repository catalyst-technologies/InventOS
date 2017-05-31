<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class login extends CI_Controller {


    public function __construct() {
        parent::__construct();
        $this->load->library(array('session'));
        $this->load->helper(array('url'));
        $this->load->model('user_model');
        $this->load->model('meta_model');
        $this->load->model('cycle_model');
    }

    public function index() {
        // Load form helper and validation library
        $this->load->helper('form');
        $this->load->library('form_validation');

        $username = $this->input->post('username');
		$password = $this->input->post('password');

        // Set validation rules
        $this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
        $this->form_validation->set_rules('password', 'Password', 'required');
        if ($this->form_validation->run() == false) {
            $this->load->view('user/login/login');
        } else {


            $user_id = $this->user_model->resolve_user_login($username, $password);
            var_dump($password);
            if ($user_id):
                // login success

                $this->session->set_userdata('uid', $user_id);
            	$this->session->set_userdata('logged_in', true);
            	redirect('dashboard');

            else:
                $this->data['error'] = "Wrong username or password";
                // send error to the view
                $this->load->view('user/login/login', $this->data);

            endif;
        }

    }

}
