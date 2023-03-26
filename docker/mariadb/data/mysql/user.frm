TYPE=VIEW
query=select `mysql`.`global_priv`.`Host` AS `Host`,`mysql`.`global_priv`.`User` AS `User`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.plugin\') in (\'mysql_native_password\',\'mysql_old_password\'),ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.authentication_string\'),\'\'),\'\') AS `Password`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 1,\'Y\',\'N\') AS `Select_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 2,\'Y\',\'N\') AS `Insert_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 4,\'Y\',\'N\') AS `Update_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 8,\'Y\',\'N\') AS `Delete_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 16,\'Y\',\'N\') AS `Create_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 32,\'Y\',\'N\') AS `Drop_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 64,\'Y\',\'N\') AS `Reload_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 128,\'Y\',\'N\') AS `Shutdown_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 256,\'Y\',\'N\') AS `Process_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 512,\'Y\',\'N\') AS `File_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 1024,\'Y\',\'N\') AS `Grant_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 2048,\'Y\',\'N\') AS `References_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 4096,\'Y\',\'N\') AS `Index_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 8192,\'Y\',\'N\') AS `Alter_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 16384,\'Y\',\'N\') AS `Show_db_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 32768,\'Y\',\'N\') AS `Super_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 65536,\'Y\',\'N\') AS `Create_tmp_table_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 131072,\'Y\',\'N\') AS `Lock_tables_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 262144,\'Y\',\'N\') AS `Execute_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 524288,\'Y\',\'N\') AS `Repl_slave_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 1048576,\'Y\',\'N\') AS `Repl_client_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 2097152,\'Y\',\'N\') AS `Create_view_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 4194304,\'Y\',\'N\') AS `Show_view_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 8388608,\'Y\',\'N\') AS `Create_routine_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 16777216,\'Y\',\'N\') AS `Alter_routine_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 33554432,\'Y\',\'N\') AS `Create_user_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 67108864,\'Y\',\'N\') AS `Event_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 134217728,\'Y\',\'N\') AS `Trigger_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 268435456,\'Y\',\'N\') AS `Create_tablespace_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 536870912,\'Y\',\'N\') AS `Delete_history_priv`,elt(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.ssl_type\'),0) + 1,\'\',\'ANY\',\'X509\',\'SPECIFIED\') AS `ssl_type`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.ssl_cipher\'),\'\') AS `ssl_cipher`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.x509_issuer\'),\'\') AS `x509_issuer`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.x509_subject\'),\'\') AS `x509_subject`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_questions\'),0) as unsigned) AS `max_questions`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_updates\'),0) as unsigned) AS `max_updates`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_connections\'),0) as unsigned) AS `max_connections`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_user_connections\'),0) as signed) AS `max_user_connections`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.plugin\'),\'\') AS `plugin`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.authentication_string\'),\'\') AS `authentication_string`,if(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.password_last_changed\'),1) = 0,\'Y\',\'N\') AS `password_expired`,elt(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.is_role\'),0) + 1,\'N\',\'Y\') AS `is_role`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.default_role\'),\'\') AS `default_role`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_statement_time\'),0.0) as decimal(12,6)) AS `max_statement_time` from `mysql`.`global_priv`
md5=9e8063501afc8396f55d7c723632d5d8
updatable=1
algorithm=0
definer_user=mariadb.sys
definer_host=localhost
suid=1
with_check_option=0
timestamp=2022-04-05 14:45:52
create-version=2
source=SELECT\n  Host,\n  User,\n  IF(JSON_VALUE(Priv, \'$.plugin\') IN (\'mysql_native_password\', \'mysql_old_password\'), IFNULL(JSON_VALUE(Priv, \'$.authentication_string\'), \'\'), \'\') AS Password,\n  IF(JSON_VALUE(Priv, \'$.access\') &         1, \'Y\', \'N\') AS Select_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &         2, \'Y\', \'N\') AS Insert_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &         4, \'Y\', \'N\') AS Update_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &         8, \'Y\', \'N\') AS Delete_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &        16, \'Y\', \'N\') AS Create_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &        32, \'Y\', \'N\') AS Drop_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &        64, \'Y\', \'N\') AS Reload_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &       128, \'Y\', \'N\') AS Shutdown_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &       256, \'Y\', \'N\') AS Process_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &       512, \'Y\', \'N\') AS File_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &      1024, \'Y\', \'N\') AS Grant_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &      2048, \'Y\', \'N\') AS References_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &      4096, \'Y\', \'N\') AS Index_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &      8192, \'Y\', \'N\') AS Alter_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &     16384, \'Y\', \'N\') AS Show_db_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &     32768, \'Y\', \'N\') AS Super_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &     65536, \'Y\', \'N\') AS Create_tmp_table_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &    131072, \'Y\', \'N\') AS Lock_tables_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &    262144, \'Y\', \'N\') AS Execute_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &    524288, \'Y\', \'N\') AS Repl_slave_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &   1048576, \'Y\', \'N\') AS Repl_client_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &   2097152, \'Y\', \'N\') AS Create_view_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &   4194304, \'Y\', \'N\') AS Show_view_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &   8388608, \'Y\', \'N\') AS Create_routine_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &  16777216, \'Y\', \'N\') AS Alter_routine_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &  33554432, \'Y\', \'N\') AS Create_user_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') &  67108864, \'Y\', \'N\') AS Event_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') & 134217728, \'Y\', \'N\') AS Trigger_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') & 268435456, \'Y\', \'N\') AS Create_tablespace_priv,\n  IF(JSON_VALUE(Priv, \'$.access\') & 536870912, \'Y\', \'N\') AS Delete_history_priv,\n  ELT(IFNULL(JSON_VALUE(Priv, \'$.ssl_type\'), 0) + 1, \'\', \'ANY\',\'X509\', \'SPECIFIED\') AS ssl_type,\n  IFNULL(JSON_VALUE(Priv, \'$.ssl_cipher\'), \'\') AS ssl_cipher,\n  IFNULL(JSON_VALUE(Priv, \'$.x509_issuer\'), \'\') AS x509_issuer,\n  IFNULL(JSON_VALUE(Priv, \'$.x509_subject\'), \'\') AS x509_subject,\n  CAST(IFNULL(JSON_VALUE(Priv, \'$.max_questions\'), 0) AS UNSIGNED) AS max_questions,\n  CAST(IFNULL(JSON_VALUE(Priv, \'$.max_updates\'), 0) AS UNSIGNED) AS max_updates,\n  CAST(IFNULL(JSON_VALUE(Priv, \'$.max_connections\'), 0) AS UNSIGNED) AS max_connections,\n  CAST(IFNULL(JSON_VALUE(Priv, \'$.max_user_connections\'), 0) AS SIGNED) AS max_user_connections,\n  IFNULL(JSON_VALUE(Priv, \'$.plugin\'), \'\') AS plugin,\n  IFNULL(JSON_VALUE(Priv, \'$.authentication_string\'), \'\') AS authentication_string,\n  IF(IFNULL(JSON_VALUE(Priv, \'$.password_last_changed\'), 1) = 0, \'Y\', \'N\') AS password_expired,\n  ELT(IFNULL(JSON_VALUE(Priv, \'$.is_role\'), 0) + 1, \'N\', \'Y\') AS is_role,\n  IFNULL(JSON_VALUE(Priv, \'$.default_role\'), \'\') AS default_role,\n  CAST(IFNULL(JSON_VALUE(Priv, \'$.max_statement_time\'), 0.0) AS DECIMAL(12,6)) AS max_statement_time\n  FROM global_priv;
client_cs_name=utf8mb4
connection_cl_name=utf8mb4_general_ci
view_body_utf8=select `mysql`.`global_priv`.`Host` AS `Host`,`mysql`.`global_priv`.`User` AS `User`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.plugin\') in (\'mysql_native_password\',\'mysql_old_password\'),ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.authentication_string\'),\'\'),\'\') AS `Password`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 1,\'Y\',\'N\') AS `Select_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 2,\'Y\',\'N\') AS `Insert_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 4,\'Y\',\'N\') AS `Update_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 8,\'Y\',\'N\') AS `Delete_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 16,\'Y\',\'N\') AS `Create_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 32,\'Y\',\'N\') AS `Drop_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 64,\'Y\',\'N\') AS `Reload_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 128,\'Y\',\'N\') AS `Shutdown_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 256,\'Y\',\'N\') AS `Process_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 512,\'Y\',\'N\') AS `File_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 1024,\'Y\',\'N\') AS `Grant_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 2048,\'Y\',\'N\') AS `References_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 4096,\'Y\',\'N\') AS `Index_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 8192,\'Y\',\'N\') AS `Alter_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 16384,\'Y\',\'N\') AS `Show_db_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 32768,\'Y\',\'N\') AS `Super_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 65536,\'Y\',\'N\') AS `Create_tmp_table_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 131072,\'Y\',\'N\') AS `Lock_tables_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 262144,\'Y\',\'N\') AS `Execute_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 524288,\'Y\',\'N\') AS `Repl_slave_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 1048576,\'Y\',\'N\') AS `Repl_client_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 2097152,\'Y\',\'N\') AS `Create_view_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 4194304,\'Y\',\'N\') AS `Show_view_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 8388608,\'Y\',\'N\') AS `Create_routine_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 16777216,\'Y\',\'N\') AS `Alter_routine_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 33554432,\'Y\',\'N\') AS `Create_user_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 67108864,\'Y\',\'N\') AS `Event_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 134217728,\'Y\',\'N\') AS `Trigger_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 268435456,\'Y\',\'N\') AS `Create_tablespace_priv`,if(json_value(`mysql`.`global_priv`.`Priv`,\'$.access\') & 536870912,\'Y\',\'N\') AS `Delete_history_priv`,elt(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.ssl_type\'),0) + 1,\'\',\'ANY\',\'X509\',\'SPECIFIED\') AS `ssl_type`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.ssl_cipher\'),\'\') AS `ssl_cipher`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.x509_issuer\'),\'\') AS `x509_issuer`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.x509_subject\'),\'\') AS `x509_subject`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_questions\'),0) as unsigned) AS `max_questions`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_updates\'),0) as unsigned) AS `max_updates`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_connections\'),0) as unsigned) AS `max_connections`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_user_connections\'),0) as signed) AS `max_user_connections`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.plugin\'),\'\') AS `plugin`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.authentication_string\'),\'\') AS `authentication_string`,if(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.password_last_changed\'),1) = 0,\'Y\',\'N\') AS `password_expired`,elt(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.is_role\'),0) + 1,\'N\',\'Y\') AS `is_role`,ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.default_role\'),\'\') AS `default_role`,cast(ifnull(json_value(`mysql`.`global_priv`.`Priv`,\'$.max_statement_time\'),0.0) as decimal(12,6)) AS `max_statement_time` from `mysql`.`global_priv`
mariadb-version=100703
