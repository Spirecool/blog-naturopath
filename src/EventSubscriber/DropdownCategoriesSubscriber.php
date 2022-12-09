<?php

namespace App\EventSubscriber;

use App\Repository\Post\CategoryRepository;
use Doctrine\Common\EventSubscriber;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Twig\Environment;

// Afficher les categories sur toutes les pages
class DropdownCategoriesSubscriber implements EventSubscriberInterface
{
    const ROUTES = ['app_post_index', 'app_category_index'];

    //pour récupérer les catégories
    public function __construct(
        private CategoryRepository $categoryRepository,
        private Environment $environment
        ) {
    }

    public function injectGlobalVariable(RequestEvent $event) : void
    {
        $route = $event->getRequest()->get('_route');
        if(in_array($route, DropdownCategoriesSubscriber::ROUTES)) {
            $categories = $this->categoryRepository->findAll();
            $this->environment->addGlobal('allCategories', $categories);
        }
    }

    public static function getSubscribedEvents()
    {
        return [KernelEvents::REQUEST => 'injectGlobalVariable'];
    }
}