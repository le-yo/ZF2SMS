<?php
namespace Sms\Model;

class SmsSettingsTableData
{
    public $value;
    public $slug;
    //public $message_id;
    //public $from_number;

    public function exchangeArray($data)
    {
        $this->value     = (!empty($data["value"])) ? $data["value"] : null;
        $this->slug = (!empty($data['slug'])) ? $data['slug'] : null;
        //$this->message_id  = (!empty($data['message_id'])) ? $data['message_id'] : null;
        //$this->from_number  = (!empty($data['from_number'])) ? $data['from_number'] : null;
    }
}