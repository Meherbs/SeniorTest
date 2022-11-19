# Introduction : 
Create a news parsing service from a news resource, i use this api https://newsapi.org/.

The service must have a page displaying the list of downloaded news and a CLI command 
to start parsing named : ('app:parse-news') so this command is runned by a cron job each 15 minutes.
This command will dispatch the call of the service to parse the news articles from the API via
async task handled by rabbitMq.

The application has a secured authentication (Admin with credentials (admin/password) who has privilege 
to delete article from the database) and (User with credentials(test / password) who can't delete the article but can
access to the list of articles).

---------------------------------------------
# Time to run the application with docker ?
### - 1) git clone the repository
### - 2) run <code>cp project/.env.test project/.env </code>
#### then update the <code>APP_SECRET</code> and <code>NEWS_API_KEY</code> with your secrect keys
### - 3) run <code>docker-compose up --build</code>
### - 4) access inside the 'seniortest-www' container (docker exec -it container_id (docker container ls to find the container_id) bash)
### - 5) run <code>chmod +x project/install.sh && project/install.sh </code>

-------------------------------------------------
## Access : 
-- PHPmyAdmin : http://localhost:8080 (credentials: root/) (without password)
------------------------------------------------------------
-- RabbitMq UI : http://localhost:15672 (credentials guest/guest)
--------------------------------------------------------
-- MySql : root:@127.0.0.1:3306
------------------------------------------------------
-- Symfony project :  http://localhost:8741
-----------------------------------------------------
