<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * meta_model class.
 * 
 * @extends CI_Model
 */
class meta_model extends MY_Model {

    public $table = 'usermeta';
    public $primary_key = 'id';
    /**
     * Create a user meta_data
     * @param int $user_id
     * @param string $meta_key
     * @param string $meta_value
     * @param array $args
     * @return int|boolean
     */
    public function create($user_id, $meta_key, $meta_value, $args = array()) {

        $args = array(
            'user_id' => $user_id,
            'meta_key' => $meta_key,
            'meta_value' => $meta_value
        );

        return parent::_create($args);
    }
    /**
     * Update a user meta_data
     * @param int $user_id
     * @param string $meta_key
     * @param string $meta_value
     */
    public function update($user_id, $meta_key, $meta_value) {
        $this->db->where('user_id', $user_id);
        $this->db->where('meta_key', $meta_key);
        $this->db->set('meta_value', $meta_value);
        $this->db->update($this->table);
    }
    /**
     * delete a user meta_data
     * @param int $user_id
     * @param string $meta_key
     */
    public function delete($user_id, $meta_key) {

        $this->db->where('user_id', $user_id);
        $this->db->where('meta_key', $meta_key);
        $this->delete($this->table);
    }
    /**
     * Check if a user meta_data exists
     * @param type $user_id
     * @param type $meta_key
     */
    public function has_meta($user_id, $meta_key) {

        $this->db->where('user_id', $user_id);
        $this->db->where('meta_key', $meta_key);
    }

    public function get($user_id, $meta_key) {
        $this->db->select('meta_value');
        $this->db->from('usermeta');
        $this->db->where('user_id', $user_id);
        $this->db->where('meta_key', $meta_key);

        return $this->db->get()->row('meta_value');
    }

    public function get_link_id($encryption_link) {

        $this->db->select('user_id');
        $this->db->from('usermeta');
        $this->db->where('meta_value', $encryption_link);

        return $this->db->get()->row('user_id');
    }

    public function validate_link($encryption_link){

  $this->db->select('meta_value');
  $this->db->from($this->table);
  $this->db->where('meta_value', $encryption_link);

  $link_check = $this->db->get()->row('meta_value');
    if ($link_check){
      return true;
    }else{
      return false;
    }

    }

    public function calculate($entry_amount) {

        $a = $entry_amount * 2000;
        $x = $a / 2;
        $y = $x / 2;

        return $y;
    }

    public function referral_count($user_id,$meta_key){

      
    }

    /*
      public function add_basic_user_meta($user_id, $meta_key, $meta_value) {
      $metadata = array(
      'user_id' => $user_id,
      'meta_key' => $meta_key,
      'meta_value' => $meta_value,
      );
      return $this->db->insert('usermeta', $metadata);
      }

      public function get($user_id, $meta_key) {
      $this->db->select('meta_value');
      $this->db->from('usermeta');
      $this->db->where('user_id', $user_id);
      $this->db->where('meta_key', $meta_key);

      return $this->db->get()->row('meta_value');
      }

      public function get_link_id($encryption_link) {

      $this->db->select('user_id');
      $this->db->from('usermeta');
      $this->db->where('meta_value', $encryption_link);

      return $this->db->get()->row('user_id');
      }

      public function update($user_id, $meta_key, $meta_value) {

      $this->db->set('meta_value', $meta_value);
      $this->db->where('user_id', $user_id);
      $this->db->where('meta_key', $meta_key);
      $this->db->update('usermeta');
      }

      public function calculate($entry_amount) {
      $a = $entry_amount * 2000;
      $x = $a / 2;
      $y = $x / 2;
      return $y;
      }
     * 
     */
}
