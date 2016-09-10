<?php
namespace config;

class Result
{
    var $isSuccess;
    var $message;
    var $result;
 /**
     * @return the $result
     */
    public function getResult()
    {
        return $this->result;
    }

 /**
     * @param field_type $result
     */
    public function setResult($result)
    {
        $this->result = $result;
    }

 /**
     * @return the $isSuccess
     */
    public function getIsSuccess()
    {
        return $this->isSuccess;
    }

 /**
     * @return the $message
     */
    public function getMessage()
    {
        return $this->message;
    }

 /**
     * @param field_type $isSuccess
     */
    public function setIsSuccess($isSuccess)
    {
        $this->isSuccess = $isSuccess;
    }

 /**
     * @param field_type $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

       
}

?>