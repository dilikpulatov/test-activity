# App Activity


###Step 1
Create file .env.local from example .env

###Step 2
~~~
docker run --rm --interactive --tty \
  --volume $(pwd):/app \
  composer update
~~~

###Step 3
~~~
docker network create --subnet=172.88.0.0/16 activity_network
~~~

###Step 4
~~~
docker-compose --env-file .env.local up --build -d
~~~

###Step 5
~~~
docker exec -it test_activity bash -c "cd /app && php yii migrate"
~~~