<?php
class Email_Server
{
    public function __construct()
    {
        $this->CI = get_instance();
    }
    public function sendEmail($email, $subject, $message)
    {
        $this->CI->load->config('email');
        $this->CI->load->library('email');
        $from = $this->CI->config->item('smtp_user');
        $this->CI->email->set_newline("\r\n");
        $this->CI->email->from($from, 'Admin PesanLokal');
        $this->CI->email->to($email);
        $this->CI->email->subject($subject);
        $this->CI->email->message($message);
        if ($this->CI->email->send()) {
            return 'ok';
        } else {
            log_message('error', $this->CI->email->print_debugger());
            return 'bad';
        }
    }
}
