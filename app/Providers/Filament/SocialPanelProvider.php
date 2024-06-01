<?php

namespace App\Providers\Filament;

use Filament\Pages;
use Filament\Panel;
use Filament\Widgets;
use Filament\PanelProvider;
use Filament\Navigation\MenuItem;
use Filament\Support\Colors\Color;
use App\Http\Middleware\VerifyIsSocial;
use Filament\Http\Middleware\Authenticate;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;

class SocialPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('social')
            ->path('social')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->userMenuItems([
                MenuItem::make()
                    ->label('User Dashboard')
                    ->icon('heroicon-o-user-circle')
                    ->url('/'),
                MenuItem::make()
                    ->label('Admin Dashboard')
                    ->icon('heroicon-o-shield-check')
                    ->url('admin')
                    ->visible(fn():bool => auth()->user()->is_admin),
                MenuItem::make()
                    ->label('Teacher Dashboard')
                    ->icon('heroicon-o-finger-print')
                    ->url('/teacher')
                    ->visible(fn():bool => auth()->user()->is_teacher),
            ])
            ->discoverResources(in: app_path('Filament/Social/Resources'), for: 'App\\Filament\\Social\\Resources')
            ->discoverPages(in: app_path('Filament/Social/Pages'), for: 'App\\Filament\\Social\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Social/Widgets'), for: 'App\\Filament\\Social\\Widgets')
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
                VerifyIsSocial::class,
            ]);
            // ->authMiddleware([
            //     Authenticate::class,
            // ]);
    }
}
