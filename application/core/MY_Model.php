<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Model extends CI_Model {

    public $table = null;
    public $primary_key = null;

    public function __construct() {
	parent::__construct();
	$this->load->database();
    }

    public function _create($args = array()) {
	if (empty($args))
	    return;
	foreach ($args as $key => $value):
	    $this->db->set($key, $value);
	endforeach;
	$this->db->insert($this->table);
	return $this->db->insert_id();
    }

    public function _update_arr($primary_key, $args = array()) {
	if (empty($args))
	    return;
	foreach ($args as $key => $value):
	    $this->db->set($key, $value);
	endforeach;
	$this->db->where($this->primary_key, $primary_key);
	return (bool) $this->db->update($this->table);
    }

    public function _delete($primary_key) {
	$this->db->where($this->primary_key, $primary_key);
	return (bool) $this->db->delete($this->table);
    }

    public function _search($args = array(), $fields = array(), $absolute = true) {
	if (empty($args)):
	    return array(); # return an empty array
	else:
	    if (!empty($fields)):
		$fields = implode(',', $fields);
		$this->db->select($fields);
	    endif;
	    foreach ($args as $key => $value):
		if ($absolute):
		    $this->db->where($key, $value);
		else:
		    $this->db->like($key, $value);
		endif;
	    endforeach;
	    return $this->db->get()->result_array();
	endif;
    }

    public function _get_by_id($primary_key, $fields = array()) {
	if (!empty($fields)):
	    $fields = implode(',', $fields);
	    $this->db->select($fields);
	endif;
	$this->db->where($this->primary_key,$primary_key);
	return $this->db->get($this->table)->row();
    }

}
