<?php
namespace Drupal\add_domain\Form;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
/**
 * Class DeleteNodeForm.
 *
 * @package Drupal\add_domain\Form
 */
class AddNodeForm extends FormBase {
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'add_node_form';
  }
  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $form['add_node'] = array(
      '#type' => 'submit',
      '#value' => $this->t('Add Nodes to Domain'),
    );
    return $form;
  }
  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    // $nids = \Drupal::entityQuery('node')->execute();
    $nids = \Drupal::entityQuery('node')->execute();
    $a = $nids;
    $batch = array(
      'title' => t('Adding Nodes to Domain...'),
      'operations' => array(
        array(
          '\Drupal\add_domain\AddNode::addNodeExample',
          array($nids)
        ),
      ),
      'finished' => '\Drupal\add_domain\AddNode::addNodeExampleFinishedCallback',
    );
    batch_set($batch);
  }
}