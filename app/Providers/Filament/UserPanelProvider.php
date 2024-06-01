<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Support\Assets\Css;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Blade;
use App\View\Components\FontAwesomeIcon;
use Filament\Navigation\NavigationGroup;
use Filament\Http\Middleware\Authenticate;
use Filament\Support\Facades\FilamentAsset;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class UserPanelProvider extends PanelProvider
{
    public function boot()
    {
        FilamentAsset::register([
            Css::make('fontawesome', asset('fontawesome/css/all.min.css')),
        ]);

        Blade::component('font-awesome-icon', FontAwesomeIcon::class);
    }

    public function panel(Panel $panel): Panel
    {

        return $panel
            ->id('user')
            ->path('/')
            ->login()
            ->registration()
            ->emailVerification()
            ->passwordReset()
            ->colors([
                'primary' => Color::Violet,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('Admin Dashboard')
                    ->icon('heroicon-o-shield-check')
                    ->url('admin')
                    ->visible(fn():bool => auth()->user()->is_admin),
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
                ->label('My Inventory Settings')
            ])
            ->discoverResources(in: app_path('Filament/User/Resources'), for: 'App\\Filament\\User\\Resources')
            ->discoverPages(in: app_path('Filament/User/Pages'), for: 'App\\Filament\\User\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/User/Widgets'), for: 'App\\Filament\\User\\Widgets')
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
