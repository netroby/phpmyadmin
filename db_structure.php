<?php
/* vim: set expandtab sw=4 ts=4 sts=4: */
/**
 * Database structure manipulation
 *
 * @package PhpMyAdmin
 */

namespace PMA;

use PMA\libraries\controllers\DatabaseStructureController;
use PMA\libraries\Response;
use PMA\libraries\Util;

require_once 'libraries/common.inc.php';
require_once 'libraries/db_common.inc.php';

list(
    $tables,
    $num_tables,
    $total_num_tables,
    $sub_part,
    $is_show_stats,
    $db_is_system_schema,
    $tooltip_truename,
    $tooltip_aliasname,
    $pos
) = Util::getDbInfo($GLOBALS['db'], isset($sub_part) ? $sub_part : '');

$container = libraries\di\Container::getDefaultContainer();
$container->factory('PMA\libraries\controllers\DatabaseStructureController');
$container->alias(
    'DatabaseStructureController', 'PMA\libraries\controllers\DatabaseStructureController'
);
$container->set('PMA\libraries\Response', Response::getInstance());
$container->alias('response', 'PMA\libraries\Response');

global $db, $pos, $db_is_system_schema, $total_num_tables, $tables, $num_tables;
/* Define dependencies for the concerned controller */
$dependency_definitions = array(
    'db' => $db,
    'url_query' => &$GLOBALS['url_query'],
    'pos' => $pos,
    'db_is_system_schema' => $db_is_system_schema,
    'num_tables' => $num_tables,
    'total_num_tables' => $total_num_tables,
    'tables' => $tables,
);

/** @var DatabaseStructureController $controller */
$controller = $container->get('DatabaseStructureController', $dependency_definitions);
$controller->indexAction();
