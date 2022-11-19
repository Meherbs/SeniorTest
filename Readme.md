# Steps
## Access : 
-- PHPmyAdmin : http://localhost:8080 (credentials: root/) (without password)
------------------------------------------------------------
-- RabbitMq UI : http://localhost:15672 (credentials guest/guest)
--------------------------------------------------------
-- MySql : root:@127.0.0.1:3306
------------------------------------------------------
-- Symfony project :  http://localhost:8741
-----------------------------------------------------

run php bin/console messenger:consume async -vv
