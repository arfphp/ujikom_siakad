<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use App\Filament\Resources\MahasiswaResource;
use App\Filament\Resources\DosenResource;
use Filament\Navigation\NavigationItem;
use App\Filament\Pages\Auth\Register;
use App\Filament\Pages\Profile;
use App\Filament\Resources\JadwalAkademikResource;
use App\Filament\Resources\UserAccountsResource;
use App\Filament\Resources\PresensiAkademikResource;
use App\Filament\Resources\MataKuliahResource;

use Illuminate\Support\Facades\Auth;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            // ->authGuard('web')
            // ->authPasswordBroker('users')
            ->login()
            ->brandName('SIAKAD')
            ->registration(Register::class)
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationItems([
                // NavigationItem::make('Mahasiswa')
                //     ->url(fn (): string => MahasiswaResource::getUrl())
                //     ->icon('heroicon-o-user-group')
                //     ->visible(fn (): bool => auth()->user()->isAdmin()),

                // // Untuk Admin
                // NavigationItem::make('Dosen')
                //     ->url(fn (): string => DosenResource::getUrl())
                //     ->icon('heroicon-o-academic-cap')
                //     ->visible(fn (): bool => auth()->user()->isAdmin()),

                // Untuk Dosen
                // NavigationItem::make('Jadwal Mengajar')
                //     ->url(fn (): string => JadwalAkademikResource::getUrl())
                //     ->icon('heroicon-o-calendar')
                //     ->visible(fn (): bool => auth()->user()->isDosen()),

                // NavigationItem::make('Presensi')
                //     ->url(fn (): string => PresensiAkademikResource::getUrl())
                //     ->icon('heroicon-o-clipboard-document-check')
                //     ->visible(fn (): bool => auth()->user()->isDosen()),

                NavigationItem::make('Profile')
                    ->url(fn (): string => Profile::getUrl())
                    ->icon('heroicon-o-user')
                    ->visible(fn (): bool => auth()->user()?->role !== 'admin'),
                // NavigationItem::make('Dashboard')
                //     ->icon('heroicon-o-home')
                //     ->url('/admin'),
                // NavigationItem::make('Manajemen User')
                //     ->icon('heroicon-o-users')
                //     ->url(UserAccountsResource::getUrl())
                //     ->visible(fn () => auth()->user()->isAdmin()),
                // NavigationItem::make('Manajemen Mata Kuliah')
                //     ->icon('heroicon-o-book-open')
                //     ->url(MataKuliahResource::getUrl())
                //     ->visible(fn () => auth()->user()->isAdmin()),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                \App\Filament\Pages\Profile::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                // Widgets\FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class, // Pastikan di posisi ini
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \App\Http\Middleware\CheckProfileComplete::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
