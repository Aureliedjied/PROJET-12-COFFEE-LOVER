<?php

namespace App\EventSubscriber;

use Knp\Component\Pager\Event\ItemsEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Finder\Finder;

final class PaginationSubscriber implements EventSubscriberInterface
{
    public function items(ItemsEvent $event): void
    {
        if (!is_string($event->target) || !is_dir($event->target)) {
            return;
        }
        $finder = new Finder();
        $finder
            ->files()
            ->depth('< 4') // 3 levels
            ->in($event->target)
        ;
        $iterator = $finder->getIterator();
        $files = iterator_to_array($iterator);
        $event->count = count($files);
        $event->items = array_slice($files, $event->getOffset(), $event->getLimit());
        $event->stopPropagation();
    }

    public static function getSubscribedEvents(): array
    {
        return [
            'knp_pager.items' => ['items', 1/* increased priority to override any internal */]
        ];
    }
}
