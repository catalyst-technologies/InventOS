<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class register extends CI_Controller {
    public function __construct() {

		parent::__construct();
		$this->load->helper('form');
		$this->load->library('form_validation');
		$this->load->helper(array('url'));
		$this->load->model('user_model');
		$this->load->model('cycle_model');
                $this->load->model('media_model');
        $this->load->helper('cookie');

    }
    private function validate_form() {
        // set validation rules
        $this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another one.'));
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
        $this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
        if ($this->form_validation->run() === false) {
            return false;
        } else {
            return true;
        }
    }
    public function index() {

        if ($this->validate_form()) {
            
            // set variables from the form
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $password = $this->input->post('password');
            $new_user_id = $this->user_model->create($username, $email, $password);
            
            if ($new_user_id) {
                // params $user_id,$meta_key,$meta_value
                $firstname = $this->input->post('firstname');
                $lastname = $this->input->post('lastname');
                $displayname = $firstname . ' ' . $lastname;
                $this->meta_model->create($new_user_id, 'firstname', $firstname);
                $this->meta_model->create($new_user_id, 'lastname', $lastname);
                $this->meta_model->create($new_user_id, 'birthday', $this->input->post('birthday'));
                $this->meta_model->create($new_user_id, 'gender', $this->input->post('gender'));
                $this->meta_model->create($new_user_id, 'contact', $this->input->post('contact'));
                $this->meta_model->create($new_user_id, 'country', $this->input->post('country'));
                $this->meta_model->create($new_user_id, 'province', $this->input->post('province'));
                $this->meta_model->create($new_user_id, 'city', $this->input->post('city'));
                $this->meta_model->create($new_user_id, 'zipcode', $this->input->post('zipcode'));

                $this->meta_model->create($new_user_id, 'displayname', $displayname);
                $this->meta_model->create($new_user_id, 'middlename', '');
                $this->meta_model->create($new_user_id, 'description', '');
                $this->meta_model->create($new_user_id, 'bio', '');
                $this->meta_model->create($new_user_id, 'facebook', '');
                $this->meta_model->create($new_user_id, 'twitter', '');
                $this->meta_model->create($new_user_id, 'google+', '');
                #$this->meta_model->create($new_user_id, 'referral', '0'); 

                /*
    
                */

                //if(paid){}
                //to do payment method
                $paid = 1;
                if ($paid = 1) {
                    $this->meta_model->create($new_user_id, 'cash', '500');
                    $this->meta_model->create($new_user_id, 'gc', '500');
                    //do cycle
                    $this->cycle_model->add($new_user_id);
                    $this->meta_model->create($new_user_id, 'entries', '1');
                    
                    $ref_link = $_COOKIE['uvm_referral'];
                        
                        if ($ref_link) {
                        $ref_id = $this->meta_model->get_link_id($ref_link); 
                        
                        $meta_referral_cash = $this->meta_model->get($ref_id, 'cash');
                        $meta_referral_cash += 500;
                        $this->meta_model->update($ref_id, 'cash', $meta_referral_cash);
                        
                        $meta_refferal_count = $this->meta_model->get($ref_id, 'referrals');
                        $meta_referral_count += 1;
                        $this->meta_model->update($ref_id, 'referrals', $meta_referral_count);

                        $this->meta_model->create($ref_id, 'referral_user', $new_user_id);
                        
                        setcookie("uvm_referral", "", time() - 3600);
                        //delete_cookie('uvm_referral');
                        
                        }

                }

                redirect('login');
                //referrals
                
                //$this->load->view('footer');
            } else {
                // user creation failed, this should never happen
                $data->error = 'There was a problem creating your new account. Please try again.';
                // send error to the view
                $this->load->view('user/login/login',$data);
            }
        }
    }

}
