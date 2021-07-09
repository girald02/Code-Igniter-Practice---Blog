<!-- .htaccess -->
RewriteEngine on
RewriteCond $1 !^(index\.php|assets|images|js|css|libs|uploads|icons|favicons.png|fonts)
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ ./index.php/$1 [L]

<!-- autoload.php -->
$autoload['libraries'] = array('form_validation' , 'session' , 'pagination');
$autoload['helper'] = array('url','form','text');
$autoload['model'] = array('Post_model');

<!-- config.php -->
$config['base_url'] = 'http://localhost/ci/';

<!-- database.php -->
$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => 'root',
	'password' => '',
	'database' => 'social',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

<!-- routes.php -->
// ADD
$route['add'] = 'pages/add';
// EDIT
$route['edit/(:any)'] = 'pages/edit/$1';
// DELETE
$route['delete'] = 'pages/delete';
// LOGIN
$route['login'] = 'pages/login';
// LOGOUT
$route['logout'] = 'pages/logout';

// DEFAULT VIEW
$route['default_controller'] = 'pages/view';
$route['(:any)'] = 'pages/view/$1';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



<!-- 
░█████╗░░█████╗░██████╗░███████╗░██████╗
██╔══██╗██╔══██╗██╔══██╗██╔════╝██╔════╝
██║░░╚═╝██║░░██║██║░░██║█████╗░░╚█████╗░
██║░░██╗██║░░██║██║░░██║██╔══╝░░░╚═══██╗
╚█████╔╝╚█████╔╝██████╔╝███████╗██████╔╝
░╚════╝░░╚════╝░╚═════╝░╚══════╝╚═════╝░ 
-->



<!-- CONTROLLERS -->
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


// MODEL

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



// FORM CODES
<!-- FORM START -->
<?= form_open('add'); ?>


<!-- VALIDATION ERROR ADD -->
<?= validation_errors();?>

<!-- base url -->
<?=base_url(); ?>


<!-- CREATE ERROR CHECKING POP UP -->
<?php 
	$this->session->set_flashdata('invalid_creds' , 'Invalid credentials!'); redirect(base_url() .  'login'); 

 ?>

<!-- Display eRROR to any pages controller/pages -->

<?php if ($this->session->flashdata('invalid_creds')) : ?>
  <?= '<p class="alert alert-danger">' . $this->session->flashdata('invalid_creds').'</p>';  ?>
<?php endif; ?>


<?php 
// <!-- SESSIONS -->

// <!-- SETTING SESSION -->
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

// VALIDATE SESSION 
 if ($this->session->logged_in) { ?>
 <!-- GET SESSION -->
<li><a href="<?=base_url();?>"><?php echo $this->session->fullname; ?></a> </li>



 ?>


<?php 

 // RETURN SINGLE DATA FROM DATABASE TO ARRAY
<!-- SINGLE RESULTS -->
 row_array();

<!-- MULTIPLE RESULTS -->
 result_array();

 ?>
