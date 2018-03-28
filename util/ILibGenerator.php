<?php
declare(strict_types=1);

/**
 * @todo save time of generated files
 * @todo mode force
 * @todo base run only not existed or changed change-date of files
 * @todo create and commit PhpStorm watcher with run it, add info about this to readme
 * @todo desc about this in readme
 *
 * Created by PhpStorm.
 * User: danchukas
 * Date: 2018-03-24 18:24
 */

$project_dir = \dirname(__DIR__, 1);

require_once $project_dir . '/vendor/autoload.php';

$dir = $project_dir . '/src/GlobalFunction/GlobalFunctionLib';
$dir_dest = $project_dir . '/src/GlobalFunction';

$this_file = str_replace($project_dir . DIRECTORY_SEPARATOR, '', __FILE__);

getLibMethods($dir, $dir_dest, 'DanchukAS\AmadeusTechTask123', 'DanchukAS\AmadeusTechTask123');

getLibMethods(
    $project_dir . '/src/ActionFunction/ActionFunctionLib',
    $project_dir . '/src/ActionFunction',
    'DanchukAS\AmadeusTechTask123'
);


function getLibMethods($dir, $dir_dest, $namespace = '', $path = null, $lib_object = null, $lib_name = null, $first_dir = null, $return = false)
{

    $r = new \ReflectionMethod(\ALib::class, 'getCalledClassName');
    $r->setAccessible(true);

    if (null === $lib_object) {
        $lib_object = $namespace . '\\' . basename($dir);
        $lib_object = new $lib_object;
    }

    if (null === $first_dir) {
        $first_dir = $dir;
    }
    if (null === $lib_name) {
        $lib_name = 'I' . basename($dir);
    }
    $file_dest = $dir_dest . DIRECTORY_SEPARATOR . "$lib_name.php";

    if (empty($path)) {
        $path = $lib_name;
    }

    $body = [];

    $m = \scandir($dir, SCANDIR_SORT_ASCENDING);
    $m = \array_slice($m, 2);

//    $child_dir_dest = $dir_dest . DIRECTORY_SEPARATOR . $lib_name;
//    $child_namespace = $namespace . '\\' . $lib_name;

    foreach ($m as $filename) {

        $child_dir = $dir . DIRECTORY_SEPARATOR . $filename;
        if (is_dir($child_dir)) {

//            $child_path = $path . '\I' . $filename;
//            $property = lcfirst($filename);
//            $body[] = " * @property $child_path " . $property;
//
//            $child_lib_object = $lib_object->$property;
//            call_user_func(__FUNCTION__, $child_dir, $child_dir_dest, $child_namespace, $child_path, $child_lib_object);

            $body_child = \call_user_func(__FUNCTION__, $child_dir, $dir_dest, $namespace, $path, $lib_object, $lib_name, $first_dir, true);

            $body = \array_merge($body, $body_child);

            continue;
        }

        $class = \basename($filename, '.php');
        $method = lcfirst($class);


        $class = $r->invoke($lib_object, $method);

        $func = new \ReflectionMethod($class, 'run');

        /** @var array $source */
        $source = \file($dir . '/' . $filename);
        $declare = $source[$func->getStartLine() - 1]; // it's actually - 1, otherwise you wont get the function() block

        $declare = \trim($declare);

        $pattern = '/^\s*(?:public\s+)?function\s+run/i';
        $declare = \preg_replace($pattern, $method, $declare);

        $pattern = '/^(.+)\s*:\s*([\w\\\\]+)\s*$/';
        $declare = \preg_replace($pattern, '${2} ${1}', $declare);


        $declare = " * @method $declare {
 * \t@uses $class::run
 * }";

        $body[] = /*$php_doc . PHP_EOL .*/
            $declare;
    }

    if ($return) {
        return $body;
    }

    global $this_file;
    write_to_file($namespace, $lib_name, $body, $this_file, $file_dest);

}

function write_to_file($namespace, $lib_name, $body, $this_file, $file_dest)
{
    $body = implode(PHP_EOL . ' *' . PHP_EOL, $body);

    $file_source = preg_replace('%(.*/)I([^/]+)%', '${1}${2}', $file_dest);

    global $project_dir;

    $file_source = str_replace($project_dir, '', $file_source);

    $body = "<?php
declare(strict_types=1);


namespace $namespace;


/**
 * Interface $lib_name
 * 
 * Generated by $this_file automatically.
 * ============ WARNING ==================== 
 * = Not edit manual !                     =
 * = If you want change something          =
 * = see implementation in $file_source = 
 * =========================================
 *
$body
 */
interface $lib_name
{ 

}
";

    file_put_contents($file_dest, $body);
}




