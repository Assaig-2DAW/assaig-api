<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'assaig-api');

// Project repository
set('repository', 'git@github.com:Assaig-2DAW/assaig-api.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true);

// Shared files/dirs between deploys
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server
add('writable_dirs', []);


// Hosts

host('100.25.202.163')
    ->user('deployer')
    ->identityFile('~/.ssh/id_rsa.pub')
    ->set('deploy_path', '/var/www/assaig-api/html');

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

/*before('deploy:symlink', 'artisan:migrate');

task('reload:php-fpm', function(){
    run('sudo /etc/init.d/php8.1-fpm restart');
});

after('deploy', 'reload:php-fpm');

task('reload:php-fpm', function(){
    run('sudo /etc/init.d/php8.1-fpm restart');
});

after('deploy', 'reload:php-fpm');
*/
//rsync -avz -e ssh /ruta/del/proyecto usuario@ip_del_servidor_destino:/ruta/del/destino
