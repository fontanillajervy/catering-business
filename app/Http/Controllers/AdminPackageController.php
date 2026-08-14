<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminPackageController extends Controller
{
    public function index() { return view('admin.packages', ['packages' => Package::orderBy('price')->get()]); }
    public function create() { return view('admin.package-form', ['package' => new Package()]); }
    public function store(Request $request) { $package = Package::create($this->validated($request)); return redirect()->route('admin.packages.index')->with('success', "{$package->name} package created."); }
    public function edit(Package $package) { return view('admin.package-form', compact('package')); }
    public function update(Request $request, Package $package) { $package->update($this->validated($request, $package)); return redirect()->route('admin.packages.index')->with('success', "{$package->name} package updated."); }
    public function destroy(Package $package) { $package->delete(); return back()->with('success', 'Package deleted.'); }

    private function validated(Request $request, ?Package $package = null): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:100'], 'description' => ['nullable', 'string'], 'price' => ['required', 'numeric', 'min:0'],
            'min_guests' => ['required', 'integer', 'min:1'], 'max_guests' => ['required', 'integer', 'gte:min_guests'], 'menu' => ['nullable', 'string'],
            'freebies' => ['nullable', 'string'], 'addons' => ['nullable', 'string'], 'event_type' => ['nullable', 'string', 'max:255'], 'is_featured' => ['nullable', 'boolean'],
        ]);
        $base = Str::slug($data['name']); $slug = $base; $number = 2;
        while (Package::where('slug', $slug)->when($package, fn ($query) => $query->whereKeyNot($package->id))->exists()) $slug = $base . '-' . $number++;
        $data['slug'] = $slug;
        $data['is_featured'] = $request->boolean('is_featured');
        return $data;
    }
}
