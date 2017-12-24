sudo cp storage/install/laravel.conf /etc/supervisor/conf.d/laravel.conf


sudo service supervisor start

sudo service supervisorctl stop-all

sudo supervisorctl reread
sudo supervisorctl update

sudo supervisorctl start redis-server
sudo supervisorctl start horizon
sudo supervisorctl start echo-server
sudo supervisorctl start rserve

sudo supervisorctl status
