<?php

namespace App\EventListener;

use App\Controller\Admin\DashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Option\EA;
use EasyCorp\Bundle\EasyAdminBundle\Contracts\Controller\DashboardControllerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Factory\AdminContextFactory;
use EasyCorp\Bundle\EasyAdminBundle\Factory\ControllerFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * @see https://github.com/EasyCorp/EasyAdminBundle/blob/4.x/src/EventListener/AdminRouterSubscriber.php
 */
class AdminRouterSubscriber implements EventSubscriberInterface
{
    private AdminContextFactory $adminContextFactory;
    private ControllerFactory $controllerFactory;

    public function __construct(
        AdminContextFactory $adminContextFactory,
        ControllerFactory $controllerFactory
    ) {
        $this->adminContextFactory = $adminContextFactory;
        $this->controllerFactory = $controllerFactory;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            RequestEvent::class => [
                ['onKernelRequest', 0],
            ],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();

        if ($this->isDashboardController($request)) {
            return;
        }

        $dashboardControllerInstance = $this->controllerFactory->getDashboardControllerInstance(DashboardController::class, $request);
        assert($dashboardControllerInstance instanceof DashboardControllerInterface);

        $adminContext = $this->adminContextFactory->create($request, $dashboardControllerInstance, null);
        $request->attributes->set(EA::CONTEXT_REQUEST_ATTRIBUTE, $adminContext);
    }

    private function isDashboardController(Request $request): bool
    {
        /** @var string */
        $controller = $request->attributes->get('_controller');
        [$controllerFqcn] = explode('::', $controller);

        return DashboardController::class === $controllerFqcn;
    }
}
