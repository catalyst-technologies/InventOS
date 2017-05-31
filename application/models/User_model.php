<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 *
 * @extends CI_Model
 */
class User_model extends MY_Model {
    public $table = 'users';
    public $primary_key = 'id';
    /**
     * @uses login Used to resolve username and password credentials
     * @param string $username
     * @param string $password
     * @return boolean
     */
    public function resolve_user_login($username, $password) {
        $this->db->select('password');
        $this->db->from($this->table);
        $this->db->where('username', $username);
        #$this->db->where('password',$password);
        $hash = $this->db->get()->row('password');
        // No. You can just hash the password from the $password param and match it to the password from the database.
        // Who ever read this, please tell mec to fix. You can then just call $this->db->get()->row and check if it is empty
        // If it is empty then username and/or password is incorrect.
        if ($this->verify_password_hash($password, $hash)) {
            $this->db->select('id');
            $this->db->from($this->table);
            $this->db->where('username', $username);
            return $this->db->get()->row('id');
        } else {
            return false;
        }
    }
    public function get($id){
        return $this->_get_by_id($id);
    }
    public function create($username, $email, $password) {

        $data = array(
            'username' => $username,
            'email' => $email,
            'password' => $this->hash_password($password),
            'created_at' => date('Y-m-j H:i:s')
        );
        return parent::_create($data);
    }
    public function update($uid,$key,$val){
        $this->db->where('id',$uid);
        $this->db->set($key,$val);
        return (bool) $this->db->update($this->table);
    }
    public function delete($user_id) {
        return $this->_delete($user_id);
    }
    public function hash_password($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }
    private function verify_password_hash($password, $hash) {
        return password_verify($password, $hash);
    }
    /**
     * @depricated - Use get function.
     * @param type $id
     * @param type $return_data
     * @return type
     */
    public function get_userdata($id, $return_data=array()){
        $this->db->select($return_data);
	$this->db->from('users');
	$this->db->where('id', $id);
        return $this->db->get()->row();
    }
}
