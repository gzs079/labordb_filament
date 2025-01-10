<?php

namespace App\Providers\Filament;

use App\Filament\Resources\ResultResource\Pages\ResultsOverview;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
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

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        $panel
            ->default()
            ->id('admin')
            ->path('/')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                //EREDETI: //Pages\Dashboard::class,
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
            ])
            ->authMiddleware([
                Authenticate::class,
            ])

            ->topNavigation()

            ->navigationItems([
                NavigationItem::make('Csak egy minta')
                   ->url('https://laraveldaily.com', shouldOpenInNewTab: true)
                   ->icon('heroicon-o-link')
                   ->group(__('module_names.navigation_groups.usefullinks')),
               NavigationItem::make('Csak egy másik minta')
                   ->url('https://filamentphp.com/', shouldOpenInNewTab: true)
                   ->icon('heroicon-o-link')
                   ->group(__('module_names.navigation_groups.usefullinks')),
               NavigationItem::make('Harmadik...')
                   ->url('https://www.php.net/', shouldOpenInNewTab: true)
                   ->icon('heroicon-o-link')
                   ->group(__('module_names.navigation_groups.usefullinks')),
                NavigationItem::make('Harmadik...')
                   ->url(fn(): string => ResultsOverview::getUrl(), shouldOpenInNewTab: false)
                   ->icon('heroicon-o-link')
                   ->group(__('module_names.navigation_groups.watersamples')),
                ])

                ->navigationGroups([
                    __('module_names.navigation_groups.administration'),
                    __('module_names.navigation_groups.watersamples'),
                    __('module_names.navigation_groups.usefullinks'),
                ])


//PRÓBA másik: resource csoportok és külső linkek működnek DE Dashboart eltünik... MENÜBE CSAK csoportként hozható vissza, Item-ként nem
/*
            ->navigation(function (NavigationBuilder $builder): NavigationBuilder {
                return $builder->groups([
                    NavigationGroup::make('Vezérlőpult')
                        ->items([
                            NavigationItem::make('Vezérlőpult')
                                ->url(route('filament.admin.pages.dashboard'))
                                ->icon('heroicon-o-home'),
                        ]),

                    NavigationGroup::make('Adattáblák kezelése')
                        ->items([
                            ...AccreditedsamplingstatusResource::getNavigationItems(),
                            ...HumvimoduleResource::getNavigationItems(),
                            ...HumviresponsibleResource::getNavigationItems(),
                            ...UnitResource::getNavigationItems(),
                            ...SamplerResource::getNavigationItems(),
                            ...SamplingreasonResource::getNavigationItems(),
                            ...SamplingsiteResource::getNavigationItems(),
                            ...SamplingtypeResource::getNavigationItems(),
                            ...ParameterResource::getNavigationItems(),
                            ...LaboratoryResource::getNavigationItems(),
                        ]),

                    NavigationGroup::make('Vízminták kezelése')
                        ->items([
                            ...ResultResource::getNavigationItems(),
                            ...SampleResource::getNavigationItems(),
                            NavigationItem::make('Csak egy minta')
                            ->url('https://laraveldaily.com', shouldOpenInNewTab: true)
                            ->icon('heroicon-o-link'),
                        ]),

                    NavigationGroup::make('Hasznos linkek')
                        ->items([
                            NavigationItem::make('Csak egy minta')
                                ->url('https://laraveldaily.com', shouldOpenInNewTab: true)
                                ->icon('heroicon-o-link'),
                            NavigationItem::make('Csak egy másik minta')
                                ->url('https://filamentphp.com/', shouldOpenInNewTab: true)
                                ->icon('heroicon-o-link'),
                            NavigationItem::make('Harmadik...')
                                ->url('https://www.php.net/', shouldOpenInNewTab: true)
                                ->icon('heroicon-o-link'),
                        ]),
                ]);
            })
*/
            ;

            return $panel;

    }
}
