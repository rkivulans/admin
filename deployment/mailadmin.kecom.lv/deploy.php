<?php
/**
 * This file is run by Gitea actions runner on the deployment server.
 */

namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'ssh://gitea@gitea.kecom.lv:48422/keco/mailadmin.git');

add('shared_files', [
    'database/database.sqlite',
]);
add('shared_dirs', []);
add('writable_dirs', []);

// Bun tasks
set('bin/bun', function () {
    return which('bun');
});
task('bun:install', function () {
    run('cd {{release_path}} && {{bin/bun}} install --frozen-lockfile');
});
task('bun:build', function () {
    run('cd {{release_path}} && {{bin/bun}} run build');
});

// Hosts

host('squid.wg.ke.com.lv')
    ->set('port', 48422)
    ->set('remote_user', 'adminkecomlv')
    ->set('http_user', 'caddy')
    ->set('deploy_path', '/var/www/adminkecomlv/mailadmin.kecom.lv');

// Hooks

after('deploy:failed', 'deploy:unlock');

after('deploy:vendors', 'bun:install');
after('bun:install', 'bun:build');
