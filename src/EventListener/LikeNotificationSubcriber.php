<?php

/**
 * Created by PhpStorm.
 * User: justin
 * Date: 3/22/19
 * Time: 5:09 PM
 */

namespace App\EventListener;

use App\Entity\LikeNotification;
use App\Entity\MicroPost;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;
use Doctrine\ORM\PersistentCollection;

class LikeNotificationSubcriber implements EventSubscriber
{
    public function getSubscribedEvents()
    {
        return [
            Events::onFlush
        ];


    }

    public function onFlush(OnFlushEventArgs $args)
    {
        $em = $args->getEntityManager();
        $uow = $em->getUnitOfWork();

        /**
         * @var PersistentCollection $collectionUpdate
         */
        foreach ($uow->getScheduledCollectionUpdates() as $collectionUpdate){
            if (!$collectionUpdate->getOwner() instanceof MicroPost){
                continue;
            }

            if ('likedBy' !== $collectionUpdate->getMapping()['fieldName']){
                continue;
            }

            $insertDiff = $collectionUpdate->getInsertDiff();
            if (!count($insertDiff)){
                return;
            }

            /**
             * @var MicroPost $microPost
             */
            $microPost = $collectionUpdate->getOwner();

            $notification = new LikeNotification();
            $notification->setUser($microPost->getUser());
            $notification->setMicroPost($microPost);
            $notification->setLikedBy(reset($insertDiff));

            $em->persist($notification);

            $uow->computeChangeSets(
                $em->getClassMetadata(LikeNotification::class),
                $notification);


        }


    }
}