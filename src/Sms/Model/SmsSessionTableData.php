<?php
namespace Sms\Model;

class SmsSessionTableData
{
    public $phone_num;
    public $sms_session;
    public $test_id;
    public $timestamp;
    public $progress;

    public function exchangeArray($data)
    {
        $this->phone_num = (!empty($data['phone_num'])) ? $data['phone_num'] : null;
        $this->sms_session = (!empty($data['sms_session'])) ? $data['sms_session'] : null;
        $this->test_id = (!empty($data['test_id'])) ? $data['test_id'] : null;
        $this->timestamp = (!empty($data['timestamp'])) ? $data['timestamp'] : null;
         $this->progress = (!empty($data['progress'])) ? $data['progress'] : null;
           }
}