<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\UserMenu;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('for_admin')]
class DashboardController extends AbstractDashboardController
{
    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Slog');
    }

    public function configureUserMenu(UserInterface $user): UserMenu
    {
        assert($user instanceof User);

        return parent::configureUserMenu($user)
            ->setAvatarUrl($user->getPhoto())
            ->setName($user->getName())
            ->addMenuItems([MenuItem::linkToRoute('home', 'fas fa-home', 'app_homepage')])
        ;
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-users', User::class);
        yield MenuItem::linkToCrud('Tag', 'fas fa-tag', Tag::class);
        yield MenuItem::subMenu('Post', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToUrl('List', 'fas fa-list', $this->url('app_post_index')),
            MenuItem::linkToUrl('Create', 'fas fa-file-circle-plus', $this->url('app_post_new')),
        ]);
    }

    public function configureAssets(): Assets
    {
        return parent::configureAssets()
            ->addWebpackEncoreEntry('admin');
    }

    /**
     * Shorten way to generate URL.
     */
    private function url(string $route): string
    {
        return $this->generateUrl($route, referenceType: UrlGeneratorInterface::ABSOLUTE_URL);
    }
}
