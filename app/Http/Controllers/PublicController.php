<?php

namespace App\Http\Controllers;

use App\Models\Package;
use App\Models\GalleryItem;
use App\Models\Service;

class PublicController extends Controller
{
    public function home()
    {
        return view('public.home');
    }

    public function about()
    {
        return view('public.about');
    }

    public function services()
    {
        $services = Service::latest()->get();

        return view('public.services', compact('services'));
    }

    public function packages()
    {
        $this->ensureSignaturePackages();
        $packages = Package::orderByRaw("CASE name WHEN 'Silver' THEN 1 WHEN 'Gold' THEN 2 WHEN 'Platinum' THEN 3 WHEN 'Diamond' THEN 4 ELSE 5 END")
            ->orderBy('price')
            ->get();

        return view('public.packages', compact('packages'));
    }

    public function packageShow(Package $package)
    {
        return view('public.package', compact('package'));
    }

    public function gallery()
    {
        return view('public.gallery', ['galleryItems' => GalleryItem::latest()->get()]);
    }

    public function reservation()
    {
        $this->ensureSignaturePackages();
        $packages = Package::orderBy('price')->get();
        $captchaQuestion = $this->captchaQuestion();

        return view('public.reservation', compact('packages', 'captchaQuestion'));
    }

    public function inquiry()
    {
        $captchaQuestion = $this->captchaQuestion();

        return view('public.inquiry', compact('captchaQuestion'));
    }

    public function contact()
    {
        return view('public.contact');
    }

    private function captchaQuestion(): string
    {
        $first = random_int(2, 9);
        $second = random_int(1, 9);
        session(['form_captcha_answer' => $first + $second]);

        return "{$first} + {$second}";
    }

    private function ensureSignaturePackages(): void
    {
        foreach ([
            ['name' => 'Silver', 'slug' => 'silver', 'description' => 'A generous buffet for relaxed celebrations and intimate gatherings.', 'price' => 550, 'min_guests' => 30, 'max_guests' => 80, 'menu' => '2 mains, pasta or noodles, vegetables, rice, dessert, and iced tea', 'freebies' => 'Basic buffet styling, menu labels, and trained service crew', 'addons' => 'Dessert station, tablescape styling, and additional mains', 'event_type' => 'Birthdays, reunions, and simple celebrations', 'is_featured' => false],
            ['name' => 'Gold', 'slug' => 'gold', 'description' => 'A crowd-pleasing selection with elevated presentation for milestone moments.', 'price' => 750, 'min_guests' => 50, 'max_guests' => 150, 'menu' => '3 mains, pasta, vegetables, rice, dessert station, and refreshments', 'freebies' => 'Styled buffet setup, menu labels, basic floral accents, and service crew', 'addons' => 'Grazing table, mocktail bar, and upgraded styling', 'event_type' => 'Debuts, anniversaries, and company events', 'is_featured' => true],
            ['name' => 'Platinum', 'slug' => 'platinum', 'description' => 'A refined menu and fuller service for memorable celebrations.', 'price' => 950, 'min_guests' => 80, 'max_guests' => 250, 'menu' => '4 mains, pasta, vegetables, rice, premium dessert station, and drinks', 'freebies' => 'Enhanced tablescape, welcome drinks, menu labels, and dedicated event lead', 'addons' => 'Live station, mobile bar, and premium floral styling', 'event_type' => 'Weddings, launches, and formal celebrations', 'is_featured' => false],
            ['name' => 'Diamond', 'slug' => 'diamond', 'description' => 'Our most complete celebration experience for grand events.', 'price' => 1250, 'min_guests' => 120, 'max_guests' => 400, 'menu' => '5 mains, live station, pasta, vegetables, rice, premium desserts, and drinks', 'freebies' => 'Full event styling consultation, upgraded tablescape, service team, and event lead', 'addons' => 'Custom menu development, lounge setup, and premium bar service', 'event_type' => 'Luxury weddings, gala dinners, and large-scale events', 'is_featured' => false],
        ] as $package) {
            // Only seed packages that do not exist. Admin edits must remain intact.
            Package::firstOrCreate(['slug' => $package['slug']], $package);
        }
    }

}
