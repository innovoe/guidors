<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cron extends Home_Controller {

    public function __construct()
    {
        parent::__construct();
    }

    //cron job actions
    public function action()
    {   

        $recurr_sessions = $this->admin_model->get_recurr_session_by_date();
        if(!empty($recurr_sessions)){
            foreach ($recurr_sessions as $value) {
                unset($value->id);
                $this->db->insert('session_booking', $value);
                $recurr_row_id = $this->db->insert_id();

                $session_repeat = get_by_id($value->session_id,'sessions')->session_repeat;
                $session_number = get_by_id($value->session_id,'sessions')->session_number;
                $date = new DateTime($value->next_recur_date);
                $date->modify('+'.$session_repeat.'day');
                $next_date = $date->format('Y-m-d');

                if(($session_number - 1) == $value->recurring_count){
                    $is_completed = 1;
                }else{
                    $is_completed = 0;;
                }

                $data = array(
                    'date' => $next_date,
                    'next_recur_date' => $next_date,
                    'recurring_count' => $value->recurring_count +1,
                    'is_completed' => $is_completed,
                );
                $data = $this->security->xss_clean($data);
                $this->admin_model->edit_option($data, $recurr_row_id, 'session_booking');
            }
        }

        
        $this->db->where('role !=', 'admin');
        $this->db->where('status', 0);
        $this->db->where('created_at <=', date('Y-m-d H:i:s', strtotime('-48 hours')));
        $pending_users = $this->db->get('users')->result();

        if (empty($pending_users)) return;

        $count   = count($pending_users);
        $subject = get_email_by_slug('admin-pending-reminder')->subject;
        $body    = get_email_by_slug('admin-pending-reminder')->body;

        $variables_data = array(
            'count' => $count,
            'days'  => '2',
        );

        $msg = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($variables_data) {
            $key = trim($matches[1]);
            return isset($variables_data[$key]) ? $variables_data[$key] : $matches[0];
        }, $body);

        $edata = array(
            'subject' => $subject,
            'msg'     => $msg,
        );

        $msg      = $this->load->view('email_template/common', $edata, true);
        $this->email_model->send_email(settings()->admin_email, $subject, $msg);



        
    }

}