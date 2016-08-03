<?php 

class Yli_Queue_Model_Job
{
    public function run($obj, $method, $params = null)
    {
        $model = Mage::getModel($obj);
        if (method_exists($model, $method)) {
            call_user_func_array(array(&$model, $method), $params);
        }else{
            Mage::throwException(Mage::helper('queue')->__('Method is not callable.'));
        }
    }
}