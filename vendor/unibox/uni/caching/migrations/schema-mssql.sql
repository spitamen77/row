/**
 * Database schema required by \uni\caching\DbCache.
 *
 * @author Nuriddin Rashidov rnn0891@gmail.com
 * @author Misbahul D Munir <misbahuldmunir@gmail.com>
 * @link http://www.efco.uz/unibox/
 * @copyright 2017 EFFECT CONSULTING
 * @license http://efco.uz/unibox/license
 * @since alfa version.7
 */

drop table if exists [cache];

create table [cache]
(
    [id]  varchar(128) not null,
    [expire] integer,
    [data]   BLOB,
    primary key ([id])
);
