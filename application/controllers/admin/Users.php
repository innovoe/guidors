<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Home_Controller {

	public function __construct()
    {
        parent::__construct();
        if (!is_admin()) {
            redirect(base_url());
        }
    }


    public function index()
    {
        $this->all_users('all');
    }

    public function all_users($type)
    {

        $data = array();
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/users/all_users/'.$type);
        $total_row = $this->admin_model->get_all_users(1 , 0, 0, $type);
        $config['total_rows'] = $total_row;
        $config['per_page'] = 15;
        $this->pagination->initialize($config);
        
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }

        $data['page_title'] = 'Users';
        $data['countries'] = $this->admin_model->select('country');
        $data['categories'] = $this->admin_model->select('categories');
        $data['users'] = $this->admin_model->get_all_users(0 , $config['per_page'], $page * $config['per_page'], $type);
        //echo '<pre>'; print_r($data['users']); exit();
        $data['main_content'] = $this->load->view('admin/users', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function mentor_details($id)
    {
        $data = array();
        $data['page'] = 'Users';   
        $data['page_title'] = 'Mentor Details';   
        $data['mentor'] = $this->admin_model->get_by_id($id, 'users');
        $data['sessions'] = $this->admin_model->get_mentor_sessions($data['mentor']->id);
        //echo '<pre>'; print_r($data['sessions']); exit();
        $data['main_content'] = $this->load->view('admin/user/mentor_details',$data,TRUE);
        $this->load->view('admin/index',$data);
    }

    public function mentees()
    {
        $data = array();
        $this->load->library('pagination');
        $config['base_url'] = base_url('admin/users/mentee');
        $total_row = $this->admin_model->get_all_mentees(1 , 0, 0);
        $config['total_rows'] = $total_row;
        $config['per_page'] = 15;
        $this->pagination->initialize($config);
        
        $page = $this->security->xss_clean($this->input->get('page'));
        if (empty($page)) {
            $page = 0;
        }
        if ($page != 0) {
            $page = $page - 1;
        }

        $data['page_title'] = 'Mentee';
        $data['packages'] = $this->admin_model->select('package');
        $data['users'] = $this->admin_model->get_all_mentees(0 , $config['per_page'], $page * $config['per_page']);
        $data['main_content'] = $this->load->view('admin/mentees', $data, TRUE);
        $this->load->view('admin/index', $data);
    }


    public function status_action($type, $id) 
    {

        $user = $this->admin_model->get_by_id($id, 'users');

        if ($user->role == 'user') {
            $url = base_url('admin/users');
        }else{
            $url = base_url('admin/mentee/all');
        }

        $reject_reason = NULL;
        if ($type == 3) {
            $reject_reason = $this->input->post('reject_reason');
        }
        $data = array(
            'status' => $type,
            'reject_reason' => $reject_reason
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->update($data, $id,'users');

        if($type == 1):
            if ($user->role == 'user') {
                $subject = get_email_by_slug('registrant-approval')->subject;
                $body    = get_email_by_slug('registrant-approval')->body;
                $variables_data = array(
                    'user_name' => $user->name,
                    'login_url' => base_url('login'),
                );
                $msg = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($variables_data) {
                    $key = trim($matches[1]);
                    return isset($variables_data[$key]) ? $variables_data[$key] : $matches[0];
                }, $body);
                $edata = array(
                    'subject' => $subject,
                    'msg'     => $msg,
                );
                $msg = $this->load->view('email_template/common', $edata, true);
                $this->email_model->send_email($user->email, $subject, $msg);
            }
            $this->session->set_flashdata('msg', trans('activate-successfully'));

        elseif($type == 3):
            if ($user->role == 'user') {
                $reject_reason  = $this->input->post('reject_reason') ?? '-'; 
                $subject = get_email_by_slug('registrant-rejection')->subject;
                $body    = get_email_by_slug('registrant-rejection')->body;
                $variables_data = array(
                    'user_name'        => $user->name,
                    'rejection_reason' => $reject_reason,
                );
                $msg = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($variables_data) {
                    $key = trim($matches[1]);
                    return isset($variables_data[$key]) ? $variables_data[$key] : $matches[0];
                }, $body);
                $edata = array(
                    'subject' => $subject,
                    'msg'     => $msg,
                );
                $msg = $this->load->view('email_template/common', $edata, true);
                $this->email_model->send_email($user->email, $subject, $msg);
            }
            $this->session->set_flashdata('msg', trans('reject-successfully')); // ← add করো

        else:
            $this->session->set_flashdata('msg', trans('deactivate-successfully'));

        endif;

        redirect($url);
    }

    public function change_account($id) 
    {
        $data = array(
            'account_type' => $this->input->post('type', false)
        );
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, $id, 'users');
        $this->session->set_flashdata('msg', trans('updated-successfully')); 
        redirect(base_url('admin/users'));
    }

    public function add()
    {
        $data = array();
        $data['page'] = 'Users';
        $data['page_title'] = 'Users';
        $data['categories'] = $this->admin_model->get_site_categories('categories');
        $data['countries'] = $this->admin_model->select_asc('country');
        $data['time_zones'] = $this->admin_model->select_asc('time_zone');
        $data['main_content'] = $this->load->view('admin/add_mentor', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function add_mentor()
    {
        check_status();

        if ($_POST) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('name', trans('name'), 'required');
            $this->form_validation->set_rules('email', trans('email'), 'required|valid_email');
            $this->form_validation->set_rules('password', trans('password'), 'trim|required|max_length[16]');
            $this->form_validation->set_rules('category', trans('category'), 'required');

            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('error', strip_tags(validation_errors()));
                redirect(base_url('admin/users/add'));
            }

            $mail = strtolower(trim($this->input->post('email', true)));
            if ($this->auth_model->check_duplicate_email($mail)) {
                $this->session->set_flashdata('error', trans('email-exist'));
                redirect(base_url('admin/users/add'));
            }

            $name = $this->input->post('name', true);
            $check_slug = check_mentor_slug(str_slug($name));
            $slug = ($check_slug == 1) ? str_slug($name).'-'.random_string('numeric', 3) : str_slug($name);

            $phone = $this->input->post('phone', true);
            if ($phone === '' || $phone === null) {
                $phone = '0';
            }

            $data = array(
                'name' => $name,
                'slug' => $slug,
                'user_name' => str_slug($name),
                'email' => $mail,
                'phone' => $phone,
                'password' => hash_password($this->input->post('password', true)),
                'role' => 'user',
                'user_type' => 'registered',
                'category' => $this->input->post('category', true),
                'language' => $this->input->post('language', true),
                'country' => $this->input->post('country', true) ?: settings()->country,
                'time_zone' => $this->input->post('time_zone', true) ?: settings()->time_zone,
                'gender' => $this->input->post('gender', true),
                'respond_in' => $this->input->post('respond_in', true),
                'respond_time' => $this->input->post('respond_time', true),
                'level' => $this->input->post('level', true),
                'experience_year' => $this->input->post('experience_year', true),
                'company' => $this->input->post('company', true),
                'designation' => $this->input->post('designation', true),
                'trial_expire' => date('Y-m-d'),
                'status' => 1,
                'parent_id' => 0,
                'email_verified' => 1,
                'enable_appointment' => 0,
                'intervals' => 30,
                'referral_id' => substr(random_string('alnum', 5).mt_rand(), 0, 10),
                'image' => 'assets/images/no-photo-sm.png',
                'thumb' => 'assets/images/no-photo-sm.png',
                'created_at' => my_date_now()
            );
            $data = $this->security->xss_clean($data);
            $id = $this->admin_model->insert($data, 'users');

            $skills = $this->input->post('skill');
            if (!empty($skills) && is_array($skills)) {
                foreach ($skills as $skill) {
                    $udata = array(
                        'user_id' => $id,
                        'skill_id' => $skill,
                    );
                    $udata = $this->security->xss_clean($udata);
                    $this->admin_model->insert($udata, 'users_skill');
                }
            }

            $notify = array(
                'user_id' => $id,
                'action_id' => 0,
                'content_id' => 0,
                'text' => trans('welcome-to'). ' '. settings()->site_name,
                'noti_type' => 1,
                'noti_time' => my_date_now()
            );
            $notify = $this->security->xss_clean($notify);
            $this->common_model->insert($notify, 'notifications');

            $this->session->set_flashdata('msg', trans('inserted-successfully'));
            redirect(base_url('admin/mentors'));
        }

        redirect(base_url('admin/users/add'));
    }

    public function edit($id)
    {

        $data = array();

        $data['page_title'] = 'Users';
        $data['categories'] = $this->admin_model->get_site_categories('categories');
        $data['skills'] = $this->admin_model->get_site_skills('skills');
        $data['user'] = $this->admin_model->get_by_id($id,'users');
        $data['user_skills'] = $this->admin_model->get_skill_by_user($id);
        $data['countries'] = $this->admin_model->select_asc('country');
        $data['time_zones'] = $this->admin_model->select_asc('time_zone');
        $data['main_content'] = $this->load->view('admin/edit_mentor', $data, TRUE);
        $this->load->view('admin/index', $data);
    }

    public function update_mentor(){
        check_status();

        $id = $this->input->post('id');

        $skills = $this->input->post('skill');

        $this->admin_model->skill_delete($id,'users_skill');

        if (!empty($skills) && is_array($skills)) {
            foreach ($skills as $skill) {
                $udata = array(
                    'user_id' => $id,
                    'skill_id' => $skill,
                );
                $udata = $this->security->xss_clean($udata);
                $this->admin_model->insert($udata, 'users_skill');
            }
        }


        $data = array(
            'name' => $this->input->post('name', true),
            'email' => $this->input->post('email', true),
            'phone' => $this->input->post('phone', true),
            'gender' => $this->input->post('gender', true),
            'language' => $this->input->post('language', true),
            'country' => $this->input->post('country', true),
            'time_zone' => $this->input->post('time_zone', true),
            'respond_in' => $this->input->post('respond_in', true),
            'respond_time' => $this->input->post('respond_time', true),
            'level' => $this->input->post('level', true),
            'experience_year' => $this->input->post('experience_year', true),
            'company' => $this->input->post('company', true),
            'category' => $this->input->post('category', true),
            'designation' => $this->input->post('designation', true),
        );
  
        $data = $this->security->xss_clean($data);
        $this->admin_model->edit_option($data, $id, 'users');
        $this->session->set_flashdata('msg', trans('updated-successfully'));

        redirect(base_url('admin/mentors'));
    }


    public function reset($id)
    {
        
        $data=array(
            'password' => hash_password('1234')
        );
        $data = $this->security->xss_clean($data);
        //$this->admin_model->edit_option($data, $id, 'users');
        echo json_encode(array('st'=> 1));
        
    }


    public function delete($user_id)
    {
        check_status();
        $this->admin_model->delete($user_id,'users'); 
        echo json_encode(array('st' => 1));
        
    }


}