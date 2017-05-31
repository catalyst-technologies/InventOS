<?php
class items extends CI_Controller{
	// View items
	public function index(){
		$id = $this->input->get('id'); # Get request id
		if(empty($id)):
			// Display all items
		else:
			// Display a single item
		endif;
	}
	public function add(){
		if(empty($this->input->post()):
			return;
		endif;
	}
	public function update($id){
		if(empty($id)):
			return;
		endif;
		$args = $this->input->post();

	}
	public function remove($id){
		
	}

}
