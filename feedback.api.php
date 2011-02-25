<?php

/**
 * @file
 * Hooks provided by the Feedback module.
 */

/**
 * @addtogroup hooks
 * @{
 */

/**
 * Act on an array of feedback entry objects when loaded from the database.
 *
 * @param $entries
 *   An array of feedback entry objects, indexed by fid.
 */
function hook_feedback_load($entries) {
  $result = db_query('SELECT * FROM {my_table} WHERE fid IN (:fids)', array(':fids' => array_keys($entries)));
  foreach ($result as $record) {
    $entries[$record->fid]->foo = $result->foo;
  }
}

/**
 * Respond to creation of a new feedback entry.
 *
 * @param $entry
 *   The feedback entry object.
 *
 * @see hook_feedback_update()
 */
function hook_feedback_insert($entry) {
  db_insert('mytable')
    ->fields(array(
      'fid' => $entry->fid,
      'extra' => $entry->extra,
    ))
    ->execute();
}

/**
 * Respond to updates to a feedback entry.
 *
 * @param $entry
 *   The feedback entry object.
 *
 * @see hook_feedback_insert()
 */
function hook_feedback_update($entry) {
  db_update('mytable')
    ->fields(array('extra' => $entry->extra))
    ->condition('fid', $entry->fid)
    ->execute();
}

/**
 * Respond to deletion of a feedback entry.
 *
 * @param $entry
 *   The feedback entry object.
 *
 * @see feedback_delete_multiple()
 */
function hook_feedback_delete($entry) {
  db_delete('mytable')
    ->condition('fid', $entry->fid)
    ->execute();
}

/**
 * @} End of "addtogroup hooks".
 */
