<?php
namespace Application\Assets\Mysql\HelperObjects;
class JoinTables{
    public $on;
    public $tables;
    public SqlJoinType $type;

    public function __construct(SqlJoinType $type, $data){
        $this->type = $type;
    }
}
enum SqlJoinType
{
   case INNER;
   case LEFT;
   case RIGHT;
   case FULL_OUTER;
}
 ?>