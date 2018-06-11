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

$results = array();
$query = \Drupal::database()->select('node_field_data', 'n');
$query->fields('n', [type, nid, vid, langcode]);
$rows = $query->execute();
while ($row = $rows->fetchAssoc()) {
  $results[] = $row;
}
// echo '<pre>' . print_r($results[1], TRUE) . '</pre>';
// die();

foreach($results as $result) {
  
  $delta = 0;
  $domain = 'dev_zyxware_com';

  $insert = \Drupal::database()->insert('node__field_domain_access');
  $insert->fields([
    'bundle',
    'entity_id',
    'revision_id',
    'langcode',
    'delta',
    'field_domain_access_target_id'
  ]);
  $row_insert = $insert->values(array(
    $result['type'],
    $result['nid'],
    $result['vid'],
    $result['langcode'],
    $delta,
    $domain,
  ))->execute();

  $insert2 = \Drupal::database()->insert('node_revision__field_domain_access');
  $insert2->fields([
    'bundle',
    'entity_id',
    'revision_id',
    'langcode',
    'delta',
    'field_domain_access_target_id'
  ]);
  $row_insert2 = $insert2->values(array(
    $result['type'],
    $result['nid'],
    $result['vid'],
    $result['langcode'],
    $delta,
    $domain,
  ))->execute();
}
