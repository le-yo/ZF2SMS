<?php
namespace Sms\Model;

class Progress
{
   
    public $from_number;
    public $progress;
    public $timestamp;

    public function exchangeArray($data)
    {
        
        $this->from_number = (!empty($data['phone_number'])) ? $data['phone_number'] : null;
        $this->progress  = (!empty($data['progress'])) ? $data['progress'] : null;
        $this->timestamp  = (!empty($data['timestamp'])) ? $data['timestamp'] : null;
    }
}