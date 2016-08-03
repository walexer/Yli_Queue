# Yli_Queue
Magento队列操作类

配置示例
--------------------------------------------------
    <global>
        <queue>        	
        	<core>
        		<adapter_model>Yli_Rqueue_Model_Redis</adapter_model>
        		<maxMessages>10</maxMessages>
        		<connection>
                    <host><![CDATA[127.0.0.1]]></host>
                    <username><![CDATA[]]></username>
                    <password><![CDATA[]]></password>
                    <port>6379</port>
                    <db>4</db>
                </connection>
        	</core>
        </queue>
    </global>
