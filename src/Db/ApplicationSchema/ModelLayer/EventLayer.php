<?php
/**
 * This file is part of the evenement package.
 *
 */

namespace App\Db\ApplicationSchema\ModelLayer;

use App\Db\ApplicationSchema\Event;
use App\Db\ApplicationSchema\EventModel;
use App\Db\ApplicationSchema\RegisterModel;
use PommProject\Foundation\Session\Connection;
use PommProject\ModelManager\ModelLayer\ModelLayer;


/**
 * @author Mikael Paris <stood86@gmail.com>
 */
class EventLayer extends ModelLayer
{
    public function createEvent(Event $event)
    {
        $this->startTransaction();
        try {
            $this->setDeferrable(['application.register_event_id_fkey'], Connection::CONSTRAINTS_DEFERRED);

            $registrations = [];

            foreach ($event->getRegistrations() as $registration) {
                $registration['event_id'] = '000';

                $registrationPersist = $this->getModel(RegisterModel::class)
                    ->createAndSave($registration);

                $registrations[] = $registrationPersist;
            }

            $this->getModel(EventModel::class)
                ->insertOne($event);

            foreach ($registrations as $registration) {
                $registration->setEventId($event->getEventId());

                $this->getModel(RegisterModel::class)
                    ->updateOne(
                        $registration,
                        ['event_id']
                    );
            }

            $event->set('registrations', $registrations);

            $this->commitTransaction();
        } catch (\Exception $e) {
            $this->rollbackTransaction();

            throw $e;
        }

        return $event;
    }
}