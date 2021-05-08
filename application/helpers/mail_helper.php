<?php 
 // untuk mengirim email
 function  sendEmail($data){
    $ci = $ci = get_instance();
    $config = [
      'mailtype'  => 'html',
      'charset'   => 'utf-8',
      'protocol'  => 'smtp',
      'smtp_host' => 'mail.minangtech.com',
      'smtp_user' => $data['email_user'],
      'smtp_pass' => $data['email_password'],
      'smtp_port' => 26,
      'smtp_crypto' => 'tls',
      'newline'   => "\r\n",
    ];
    $ci->email->initialize($config);
    $ci->email->from($data['email_user'],$data['nama']);
    $ci->email->to($data['reciver_email']);

    $ci->email->subject($data['subject']);
    $ci->email->message($data['message']);

    if($ci->email->send()){
      return true;
    }else {
      echo $ci->email->print_debugger();
    }
  }