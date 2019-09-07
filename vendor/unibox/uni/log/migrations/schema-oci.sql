/**
 * Database schema required by \uni\log\DbTarget.
 *
 * The indexes declared are not required. They are mainly used to improve the performance
 * of some queries about message levels and categories. Depending on your actual needs, you may
 * want to create additional indexes (e.g. index on `log_time`).
 *
 * @author Alexander Makarov <sam@rmcreative.ru>
 * @link http://www.efco.uz/unibox/
 * @copyright 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 * @since alfa version.1
 */

drop table if exists "log";

create table "log"
(
   "id"          number(20) NOT NULL PRIMARY KEY,
   "level"       integer,
   "category"    varchar(255),
   "log_time"    number,
   "prefix"      text,
   "message"     text,
   key "idx_log_level" ("level"),
   key "idx_log_category" ("category")
);
