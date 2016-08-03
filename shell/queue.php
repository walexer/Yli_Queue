<?php


require_once 'abstract.php';

/**
 * Magento Log Shell Script
 *
 * @category    Mage
 * @package     Mage_Shell
 * @author      Walexer
 */
class Mage_Shell_Queue extends Mage_Shell_Abstract
{
    public function run(){
        while(1){
            $messages = Mage::getModel('queue/queue')->receive();
      
            foreach ($messages as $job){
                $body = $job->body;
                if(false === $body){
                    continue;
                }
                $data = $body[1];
                $data = unserialize($data);
                $obj = $data['obj'];
                $method = $data['method'];
                $params = null;
                if($data['params']){
                    $params = unserialize($data['params']);
                }
                            
                try {
                    Mage::getModel('queue/job')->run($obj, $method, $params);
                } catch (Exception $e) {
                    Mage::logException($e);
                    Mage::getModel('queue/queue')->send($obj, $method, $params);
                }            
            }
        }
    }
    

}
$shell = new Mage_Shell_Queue();
$shell->run();