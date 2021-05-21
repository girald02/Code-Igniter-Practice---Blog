<?php 

	class Post_model extends CI_Model
	{
		// Connection
		public function __construct()
		{
			$this->load->database();
		}

		// Displaying 
		public function get_posts(){
			$query = $this->db->get('post');
			return $query->result_array();
		}

		// Displaying GET by URL
		public function get_posts_single($param){
			$this->db->where('slug' , $param);
			$query = $this->db->get('post');
			return $query->row_array();
		}

		// INSERT DATA IN DATABASE
		public function insert_post(){

			// $this->input-post('title') ::: ito, input , database
			$data = array(
				'title' => $this->input->post('title') ,
				'slug' => url_title($this->input->post('title') , '-' , true),
				'body' => $this->input->post('desc'),
				'date_published' => date("F j, Y, g:i a")
				 );

			return $this->db->insert('post' , $data); // 'post'::database , $data::return value
		}


		// UPDATE DATA IN DATABASE
		public function update_post(){


			// GET ID FROM EDIT.PHP
			$id = $this->input->post('id');

			// $this->input-post('title') ::: ito, input , database
			$data = array(
				'title' => $this->input->post('title') ,
				'slug' => url_title($this->input->post('title') , '-' , true),
				'body' => $this->input->post('desc')
				 );

			 $this->db->where('id' , $id);  //WHERE QUERY
			 return $this->db->update('post' , $data); // FROM TABLE

		}

		public function get_posts_edit($param){
			$this->db->where('id' , $param);
			$query = $this->db->get('post'); //->get('psot') kung saan databased na nakalagay sa xamp

			return $query->row_array();
		}

		public function delete_post(){

			$id = $this->input->post('id');
			$this->db->where('id' , $id);
			$this->db->delete('post');
			return true;
		}

		public function login(){

			$username = $this->input->post('username', true);
			$password = $this->input->post('password', true);

			 $this->db->where('username' , $username);
			 $this->db->where('password' , $password);
			 
			 $result = $this->db->get('user'); 

			 if ($result->num_rows() == 1) {

			 	return $result->row_array();

			 }else{

			 	return false;

			 }

		}
	}

?>


