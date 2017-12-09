<?php

namespace App\Db\ApplicationSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use App\Db\ApplicationSchema\AutoStructure\Register as RegisterStructure;
use App\Db\ApplicationSchema\Register;

/**
 * RegisterModel
 *
 * Model class for table register.
 *
 * @see Model
 */
class RegisterModel extends Model
{
    use WriteQueries;

    /**
     * __construct()
     *
     * Model constructor
     *
     * @access public
     */
    public function __construct()
    {
        $this->structure = new RegisterStructure;
        $this->flexible_entity_class = '\App\Db\ApplicationSchema\Register';
    }

    public function findWithEvent($registerId) {

        $where = new Where('register.register_id = $*::int4', [$registerId]);

        $sql = <<<SQL
SELECT
  :projection
FROM :register register
INNER JOIN :event event USING (event_id)
WHERE :condition
SQL;
        $projection = $this->createProjection()
            ->setField('event', 'event', '\App\Db\ApplicationSchema\Event');

        $sql = strtr($sql,
            [
                ':projection' => $projection->formatFieldsWithFieldAlias('register'),
                ':register'      => $this->getStructure()->getRelation(),
                ':event'      => $this->getSession()
                    ->getModel(EventModel::class)
                    ->getStructure()
                    ->getRelation(),
                ':condition' => (string) $where
            ]
        );

        $iterator = $this->query($sql, $where->getValues(), $projection);

        return $iterator->isEmpty() ? null : $iterator->current();
    }
}
