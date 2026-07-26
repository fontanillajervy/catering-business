<?php

namespace App\Http\Controllers;

use App\Models\Package;
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
        $packages = Package::latest()->get();

        return view('public.packages', compact('packages'));
    }

    public function packageShow(Package $package)
    {
        return view('public.package', compact('package'));
    }

    public function gallery()
    {
        return view('public.gallery');
    }

    public function reservation()
    {
        return view('public.reservation');
    }

    public function inquiry()
    {
        return view('public.inquiry');
    }

    public function contact()
    {
        return view('public.contact');
    }
}
