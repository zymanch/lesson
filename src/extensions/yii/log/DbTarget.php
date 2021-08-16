<?php
/**
 * Created by PhpStorm.
 * User: Aleksey
 * Date: 17.11.2016
 * Time: 14:53
 */

namespace extensions\yii\log;

class DbTarget extends \yii\log\DbTarget
{

    /**
     * Stores log messages to DB.
     */
    public function export()
    {
        $tableName = $this->db->quoteTableName($this->logTable);
        $sql = "INSERT INTO $tableName ([[dmca_notice_id]], [[log]])
                VALUES (:dmca_notice_id, :message)";
        $command = $this->db->createCommand($sql);

        foreach ($this->messages as $message) {
            list($logSubject, $level, $category, $timestamp) = $message;
            if (!is_array($logSubject)) {
                continue;
            }
            $command->bindValues([
                                     ':dmca_notice_id' => $logSubject['dmca_notice_id'],
                                     ':message'        => $logSubject['text'],
                                 ])->execute();
        }
    }

}