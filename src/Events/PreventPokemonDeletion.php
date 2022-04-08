<?php

namespace App\Events;

use App\Entity\Pokemon;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class PreventPokemonDeletion implements EventSubscriberInterface
{
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['preventPokemonDeletion', EventPriorities::PRE_WRITE]
        ];
    }

    public function preventPokemonDeletion(ViewEvent $event)
    {
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if ($result instanceof Pokemon && $method == "DELETE") {
            if ($result->getLegendary() == 1) {
                $message = "VOUS NE POUVEZ PAS SUPPRIMER UN POKEMON LEGENDAIRE";
                throw new Exception($message, 422); //On aura une erreur 500 dans Postman (le 422 sert à rien en fait)
            }
        }
    }
}
