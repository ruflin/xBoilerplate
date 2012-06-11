<?php
/**
 * @author Oliver Tupman <oliver.tupman@centralway.com>
 * Date: 08/06/2012
 * Time: 16:34
 */

function copy_directory($source, $destination) {
    $result = exec('cp -R ' . $source . ' ' . $destination);
    return $result;
}

if(!file_exists('vendor')) {
    die("[deploy] FAILED: Command must be run at the same level as composer.json\n");
}

if(file_exists('httpdocs')) {
    die("[deploy] FAILED: httpdocs directory already exists, remove if you wish to deploy a new xBoilerplate skeleton\n");
}

$baseDir = __DIR__ . DIRECTORY_SEPARATOR;

mkdir('tmp');
mkdir('test');

mkdir('config');
copy($baseDir . 'config' . DIRECTORY_SEPARATOR . '/config.php', 'config' . DIRECTORY_SEPARATOR . '/config.php');

copy_directory($baseDir . 'httpdocs', '.');
copy($baseDir . "Vagrantfile", "Vagrantfile");

echo "[deploy] SUCCESS: your xBoilerplate skeleton was created\n";
echo "         You can start it by using the command: vagrant up\n";
echo "         And then accessing it via http://10.10.10.10\n";