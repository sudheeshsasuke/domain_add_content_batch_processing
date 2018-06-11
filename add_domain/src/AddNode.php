<?php
namespace Drupal\add_domain;
use Drupal\node\Entity\Node;
class AddNode {
  public static function addNodeExample($nids, &$context){
    $message = 'Adding Node...';
    $results = array();
    // foreach ($nids as $nid) {
    //   // $node = Node::load($nid);
    //   // $results[] = $node->delete();
    //   $entity =  \Drupal\node\Entity\Node::load($nid);
    //   //kint($entity); die();
    //   $domain = 'dev_zyxware_com';
    //   $domain_access = 'field_domain_access';
    //   if ($entity->hasField($domain_access)) {
    //     $entity->set($domain_access, $domain);
    //     $results[] = $entity->save();
    //   }
    // }

    //$nids = \Drupal::entityQuery('node')->execute();
    
    // $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
    $domain = 'dev_zyxware_com';
    $domain_access = 'field_domain_access';
    foreach ($nids as $nid) {
      $entity = \Drupal\node\Entity\Node::load($nid);
      if ($entity->hasField($domain_access)) {
        $entity->set($domain_access, $domain);
        $results[] = $entity->save();
      }
    }
    $context['message'] = $message;
    $context['results'] = $results;
  }
  public static function addNodeExampleFinishedCallback($success, $results, $operations) {
    // The 'success' parameter means no fatal PHP errors were detected. All
    // other error management should be handled using 'results'.
    if ($success) {
      $message = \Drupal::translation()->formatPlural(
        count($results),
        'One post processed.', '@count posts processed.'
      );
    }
    else {
      $message = t('Finished with an error.');
    }
    drupal_set_message($message);
  }
}