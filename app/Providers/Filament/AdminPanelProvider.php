<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Illuminate\View\View;
use Filament\PanelProvider;
use Filament\Pages\Dashboard;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use App\Filament\Pages\Notifications;
use App\Http\Middleware\VerifyIsAdmin;
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

DatabaseNotifications::trigger('filament.notifications.database-notifications-trigger');

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->globalSearch(true)
            ->default()
            ->id('admin')
            ->path('admin')
            ->profile()
            ->renderHook(
                PanelsRenderHook::BODY_END,
                fn (): View => view('filament.footer'),
            )
            ->colors([
                'primary' => Color::Indigo,
            ])
            // ->topNavigation()
            ->userMenuItems([
                MenuItem::make()
                    ->label('User Dashboard')
                    ->icon('heroicon-o-user-circle')
                    ->url('/'),
                MenuItem::make()
                    ->label('social Dashboard')
                    ->icon('heroicon-o-hand-thumb-up')
                    ->url('/social')
                    ->visible(fn():bool => auth()->user()->is_social_team),
                MenuItem::make()
                    ->label('Teacher Dashboard')
                    ->icon('heroicon-o-finger-print')
                    ->url('/teacher')
                    ->visible(fn():bool => auth()->user()->is_teacher),
            ])
            ->navigationGroups([
                NavigationGroup::make()
                ->label('DemoGraphic Settings'),
                NavigationGroup::make()
                ->label('User Settings'),
                NavigationGroup::make()
                ->label('Invetory Settings')

            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
            ])
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
            ->databaseNotifications();
            // ->authMiddleware([
            //     Authenticate::class,
            // ]);
    }
}
