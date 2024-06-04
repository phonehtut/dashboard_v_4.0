<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Illuminate\View\View;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Facades\Filament;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use App\Filament\Pages\Notifications;
use App\Http\Middleware\VerifyIsAdmin;
use App\Filament\Widgets\StartOverview;
use Filament\Navigation\NavigationItem;
use Filament\Navigation\NavigationGroup;
use Filament\Widgets\FilamentInfoWidget;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Notifications\Livewire\DatabaseNotifications;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

// Ensure database notifications are triggered
DatabaseNotifications::trigger('filament.notifications.database-notifications-trigger');

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin') // Set panel ID
            ->path('admin') // Define panel path
            ->profile() // Enable profile page
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): View => view('filament.footer'), // Add custom footer view
            )
            ->colors([
                'primary' => Color::Indigo, // Set primary color
            ])
            // ->navigation(false)
            // Define user menu items
            ->userMenuItems([
                MenuItem::make()
                    ->label('User Dashboard')
                    ->icon('heroicon-o-user-circle')
                    ->url('/'),
                MenuItem::make()
                    ->label('Social Dashboard')
                    ->icon('heroicon-o-hand-thumb-up')
                    ->url('/social')
                    ->visible(fn():bool => auth()->user()->is_social_team),
                MenuItem::make()
                    ->label('Teacher Dashboard')
                    ->icon('heroicon-o-finger-print')
                    ->url('/teacher')
                    ->visible(fn():bool => auth()->user()->is_teacher),
                MenuItem::make()
                    ->label('Server Traffic')
                    ->icon('heroicon-o-arrow-trending-up')
                    ->url('/pulse')
            ])
            // Define navigation groups
            ->navigationGroups([
                NavigationGroup::make('Teacher')
                    ->label('Teacher')
                    ->icon('heroicon-o-users')
                    ->collapsed(),
                NavigationGroup::make('Social')
                    ->icon('heroicon-o-users')
                    ->collapsed(),
                NavigationGroup::make('Developemt')
                    ->icon('heroicon-o-command-line')
                    ->collapsed(),
            ])
            // Define navigation items
            // ->navigationItems([
            //     NavigationItem::make()
            //         ->label('Dashboard')
            //         ->url('/admin')
            //         ->icon('heroicon-o-home')
            //         ->isActiveWhen(fn () => request()->routeIs('filament.admin.pages.dashboard')),
            //     NavigationItem::make()
            //         ->label('Students')
            //         ->url('/admin/students')
            //         ->group('Teacher')
            //         ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.students.*')),
            //     NavigationItem::make()
            //         ->label('Blog')
            //         ->url('/admin/blogs')
            //         ->group('Social')
            //         ->isActiveWhen(fn () => request()->routeIs('filament.admin.resources.blogs.*')),
            //     NavigationItem::make()
            //         ->label('Review')
            //         ->group('Social')
            //         ->url('#'),
            // ])
            // ->resources([
            //     \App\Filament\Resources\UserResource::class,
            //     \App\Filament\Resources\BlogResource::class,
            //     \App\Filament\Resources\BatchResource::class,
            //     \App\Filament\Resources\CategoryResource::class,
            //     \App\Filament\Resources\CourseResource::class,
            //     \App\Filament\Resources\GenderResource::class,
            //     \App\Filament\Resources\OsResource::class,
            //     \App\Filament\Resources\StudentResource::class,
            //     // Add other resources here
            // ])
            ->navigationItems([
                NavigationItem::make()
                ->label('Developemt Monitoring')
                ->url('/telescope', shouldOpenInNewTab: true)
                ->group('Development'),
            NavigationItem::make()
                ->label('Server Monitoring')
                ->url('/pulse', shouldOpenInNewTab: true)
                ->group('Development'),
            ])
            //Automatically discover resources
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            // Automatically discover pages
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            // Define custom pages
            ->pages([
                Pages\Dashboard::class,
            ])
            // ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets') // Uncomment to auto-discover widgets
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class, // Uncomment to include Filament info widget
                StartOverview::class,
            ])
            // Define middleware for the panel
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                VerifyIsAdmin::class
            ])
            // Enable database notifications
            ->databaseNotifications();
            // ->authMiddleware([
            //     Authenticate::class,
            // ]); // Uncomment to use custom auth middleware
    }
}
