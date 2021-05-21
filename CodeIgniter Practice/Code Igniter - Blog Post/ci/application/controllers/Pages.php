<?php 

class Pages extends CI_Controller{

	//|--------------------------------------|
	//|				DISPLAYING				 |
	//|--------------------------------------|
	public function view($param = null){

		if($param == null) {

			$page = "home";

			// Checking if the page is exist
			if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			}

			// DATA
			$data['title'] = "Latest Post";
			$data['post'] = $this->Post_model->get_posts();

			$this->load->view('templates/header');
			$this->load->view('pages/'.$page,$data);
			$this->load->view('templates/footer');

		}else{

			$page = "single";

			// Checking if the page is exist
			if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			}

			// DATA
			$data['post'] = $this->Post_model->get_posts_single($param);
			$data['id'] = $data['post']['id'];
			$data['title'] = $data['post']['title'];
			$data['body'] = $data['post']['body'];
			$data['date_published'] = $data['post']['date_published'];

			if ($data['post']){
				$this->load->view('templates/header');
				$this->load->view('pages/'.$page,$data);
				$this->load->view('templates/modal');
				$this->load->view('templates/footer');

			}else{
				show_404();
			}
		}
	}

	//|--------------------------------------|
	//|				INSERT POST				 |
	//|--------------------------------------|
	public function add(){

		// FORM VALIDATION UI
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
		$this->form_validation->set_rules('title' , 'Title' , 'required');
		$this->form_validation->set_rules('desc' , 'Desc' , 'required');

		if ($this->form_validation->run() == FALSE) {

			// views/pages
			$page = "add";

			// Checking if the page is exist
			if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			}

			// set data
			$data['title'] = "Add New Post";

			$this->load->view('templates/header');
			$this->load->view('pages/'.$page,$data);
			$this->load->view('templates/footer');
		}
		else{
			// insert query
			$this->Post_model->insert_post();

			// session para lumabas kahit saang page once na nakapag add ka na ng data
			$this->session->set_flashdata('post_added' , 'post was added');
			redirect(base_url());
		}
	}// end of ADD_FUNCTION

	//|--------------------------------------|
	//|				EDIT POST				 |
	//|--------------------------------------|
	public function edit($param){

		// FORM VALIDATION UI
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
		$this->form_validation->set_rules('title' , 'Title' , 'required');
		$this->form_validation->set_rules('desc' , 'Desc' , 'required');

		if ($this->form_validation->run() == FALSE) {

			// views/pages
			$page = "edit";

			// Checking if the page is exist
			if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			}

			// set data
			$data['titlepage'] = "Edit Post";

			// GETTING DATA THAT NEED TO BE EDIT's
			$data['post'] = $this->Post_model->get_posts_edit($param);
			$data['id'] = $data['post']['id'];
			$data['title'] = $data['post']['title'];
			$data['body'] = $data['post']['body'];
			$data['date_published'] = $data['post']['date_published'];

			$this->load->view('templates/header');
			$this->load->view('pages/'.$page,$data);
			$this->load->view('templates/footer');
		}
		else{

			// update query
			$this->Post_model->update_post();

			// session para lumabas kahit saang page once na nakapag add ka na ng data
			$this->session->set_flashdata('post_updated' , 'post updated');
			redirect(base_url() .  'edit/' . $param); 
		}
	}// end of edit_FUNCTION


	//|--------------------------------------|
	//|				DELETE POST				 |
	//|--------------------------------------|
	public function delete(){
		$this->Post_model->delete_post();
		$this->session->set_flashdata('post_deleted' , 'post was deleted');
		redirect(base_url()); 
	}


	//|--------------------------------------|
	//|				LOGIN POST				 |
	//|--------------------------------------|
	public function login(){

		// FORM VALIDATION UI
		$this->form_validation->set_error_delimiters('<div class="alert alert-danger">','</div>');
		$this->form_validation->set_rules('username' , 'username' , 'required');
		$this->form_validation->set_rules('password' , 'password' , 'required');

		if ($this->form_validation->run() == FALSE) {
			// views/pages
			$page = "login";

			// Checking if the page is exist
			if (!file_exists(APPPATH.'views/pages/'.$page.'.php')) {
				show_404();
			}


			$this->load->view('templates/header');
			$this->load->view('pages/'.$page);
			$this->load->view('templates/footer');
		}
		else{


			$user_id = $this->Post_model->login();
			
			if ($user_id) {

				$data_user = array(
								'firstname'=>$user_id['firstname'], 
								'lastname'=>$user_id['lastname'], 
								'fullname'=>$user_id['firstname'].' '.$user_id['lastname'] , 
								'access'=>$user_id['is_admin'] , 
								'logged_in'=>true 
							);
				$this->session->set_userdata($data_user);
				$this->session->set_flashdata('success_login' , 'You are now loged in as '. $this->session->fullname);
				redirect(base_url()); 
			}else{
				$this->session->set_flashdata('invalid_creds' , 'Invalid credentials!');
				redirect(base_url() .  'login'); 
			}
		}
	}//END LOGIN FUNCTION


	public function logout(){


		$this->session->unset_userdata('firstname');
		$this->session->unset_userdata('lastname');
		$this->session->unset_userdata('fullname');
		$this->session->unset_userdata('access');
		$this->session->unset_userdata('logged_in');
		redirect(base_url() .  'login'); 

	}

}
