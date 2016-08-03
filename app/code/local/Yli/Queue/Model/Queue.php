<?php 

class Yli_Queue_Model_Queue
{
    /**
     * add to queue
     * @param string $name
     * @param string $data     
     */
    public function send($obj, $method, $params = null)
    {
        if(!is_array($params)){
            Mage::throwException(Mage::helper('queue')->__('Params must be an array.'));
        }
        
        $message = array();
        $message['method'] = $method;
        $message['obj'] = $obj;
        $message['params'] = serialize($params);
        $message = serialize($message);
        
        $adapterModel = (string)Mage::getConfig()->getNode('global/queue/core/adapter_model');        
        $queueOptions = Mage::getConfig()->getNode('global/queue/core/connection')->asArray();
        if(class_exists($adapterModel)){
            $adapter = new $adapterModel($queueOptions);
        }else{
            $adapter = $adapterModel;
        }
        
        $queue = new Zend_Queue($adapter, $queueOptions);
        
        $queue->send($message);
    }
    
    public function receive()
    {
        $adapterModel = (string)Mage::getConfig()->getNode('global/queue/core/adapter_model');
        $maxMessages = (int)Mage::getConfig()->getNode('global/queue/core/maxMessages');
        $queueOptions = Mage::getConfig()->getNode('global/queue/core/connection')->asArray();
        $adapter = new $adapterModel($queueOptions);
        $queue = new Zend_Queue($adapter, $queueOptions);
        
        $messages = $queue->receive($maxMessages);
        
        return $messages;
    }
}