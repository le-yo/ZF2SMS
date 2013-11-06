<?php
namespace Sms\Model;

class Registration
{
    public $id;
    public $message;
    
    public function exchangeArray($data)
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->message = (!empty($data['message'])) ? $data['message'] : null;
      
    }
}