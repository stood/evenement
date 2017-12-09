<?php

namespace App\Db\ApplicationSchema;

use PommProject\ModelManager\Model\Model;
use PommProject\ModelManager\Model\Projection;
use PommProject\ModelManager\Model\ModelTrait\WriteQueries;

use PommProject\Foundation\Where;

use App\Db\ApplicationSchema\AutoStructure\Event as EventStructure;
use App\Db\ApplicationSchema\Event;

/**
 * EventModel
 *
 * Model class for table event.
 *
 * @see Model
 */
class EventModel extends Model
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
        $this->structure = new EventStructure;
        $this->flexible_entity_class = '\App\Db\ApplicationSchema\Event';
    }

    public function findWithCategoryAndNbRegister()
    {
        $sql = <<<SQL
SELECT
  :projection
FROM :event event
INNER JOIN :category category USING (category_id)
LEFT JOIN :register register USING (event_id)
GROUP BY event_id, category.*
SQL;
        $projection = $this->createProjection()
            ->setField('category', 'category', '\App\Db\ApplicationSchema\Category')
            ->setField('nb_register', 'count(register)', 'int4')
            ->setField('nb_day', 'extract(DAY FROM upper(event.timespan) - current_date)', 'int4');

        $sql = strtr($sql,
            [
                ':projection' => $projection->formatFieldsWithFieldAlias('event'),
                ':event'      => $this->getStructure()->getRelation(),
                ':category'      => $this->getSession()
                    ->getModel(CategoryModel::class)
                    ->getStructure()
                    ->getRelation(),
                ':register'      => $this->getSession()
                    ->getModel(RegisterModel::class)
                    ->getStructure()
                    ->getRelation()
            ]
        );

        return $this->query($sql, [], $projection);
    }

    public function findWithRegister()
    {
        $sql = <<<SQL
SELECT
  :projection
FROM :event event
LEFT JOIN :register register USING (event_id)
GROUP BY event_id
SQL;
        $projection = $this->createProjection()
            ->setField('name', "name -> 'fr'", 'varchar')
            ->setField('registers', 'array_agg(register)', '\App\Db\ApplicationSchema\Register[]');

        $sql = strtr($sql,
            [
                ':projection' => $projection->formatFieldsWithFieldAlias('event'),
                ':event'      => $this->getStructure()->getRelation(),
                ':register'      => $this->getSession()
                    ->getModel(RegisterModel::class)
                    ->getStructure()
                    ->getRelation()
            ]
        );

        return $this->query($sql, [], $projection);
    }
}
