<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\CounterOffer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{
    public function index()
    {
        $offers = Offer::with(['user', 'counterOffers'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('offers.index', compact('offers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:30|max:180',
            'description' => 'required|string|max:500',
            'location' => 'required|string',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        $offer = Offer::create([
            'user_id' => Auth::id(),
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'description' => $validated['description'],
            'location' => $validated['location'],
            'location_coordinates' => [
                'latitude' => $validated['latitude'],
                'longitude' => $validated['longitude']
            ]
        ]);

        return redirect()->route('offers.show', $offer)
            ->with('success', 'Oferta publicada exitosamente');
    }

    public function makeCounterOffer(Request $request, Offer $offer)
    {
        $validated = $request->validate([
            'price' => 'required|numeric|min:0',
            'duration' => 'required|integer|min:30|max:180',
            'message' => 'nullable|string|max:500'
        ]);

        $counterOffer = CounterOffer::create([
            'offer_id' => $offer->id,
            'psychologist_id' => Auth::id(),
            'price' => $validated['price'],
            'duration' => $validated['duration'],
            'message' => $validated['message']
        ]);

        return redirect()->back()
            ->with('success', 'Contraoferta enviada exitosamente');
    }
} 