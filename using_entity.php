<?php

// Set max execution time for php
ini_set('max_execution_time', 0);

/**
 * @file
 * The PHP page that serves all page requests on a Drupal installation.
 *
 * All Drupal code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt files in the "core" directory.
 */

use Drupal\Core\DrupalKernel;
use Symfony\Component\HttpFoundation\Request;

$autoloader = require_once 'autoload.php';

$kernel = new DrupalKernel('prod', $autoloader);

$request = Request::createFromGlobals();
$response = $kernel->handle($request);
// $response->send();

// $kernel->terminate($request, $response);

$nids = \Drupal::entityQuery('node')->execute();
//$nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
sort($nids);
$arr = array_slice($nids, 4900);
//echo '<pre>' . print_r($arr, TRUE) . '</pre>';

//die();
$a = [];
$nodes =  \Drupal\node\Entity\Node::loadMultiple($arr);
$domain = 'dev_zyxware_com';
$domain_access = 'field_domain_access';
foreach ($nodes as $entity) {
  if ($entity->hasField($domain_access)) {
    $entity->set($domain_access, $domain);
    $a[] = $entity->save();
  }
}
echo '<pre>' . print_r($a, TRUE) . '</pre>';
