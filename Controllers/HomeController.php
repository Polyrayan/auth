<?php

namespace App\Http\Controllers;

use App\Commande;
use App\Commerce;
use App\Contenir;
use App\Detenir;
use App\Panier;
use App\Produit;
use App\Reservation;

use Illuminate\Http\Request;
use App\Client;
use Illuminate\Support\Facades\DB;
use Geocoder;


class HomeController extends Controller
{
    public function show()
    {

        $mailClient = Client::getMailClient(); // todo: récuperer l'email automatiquement  une fois l'authentification fonctionnelle
        $products = Produit::productsGroupedByVariant();
        $coordinatesOfClients = Geocoder::getCoordinatesForAddress(Client::getMyAddress());
        $allProducts = Produit::all();
        foreach ($products as $product) {
            //distance
            $product->addDistance($coordinatesOfClients);
            //city
            $product->addCity();
            //colors
            $product->colors = $product->addColors($allProducts);
            //sizes
            $product->sizes = $product->addSizes($allProducts);
        }
        return view('welcome', ['products' => $products, 'mailClient' => $mailClient]);
    }

    public function selectForm(Request $request)
    {
        if ($request->has('book')) {

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0' ,'max:99999']
            ]);
            $reservation = Reservation::createReservation(request('mailClient'));
            Contenir::createContenir($reservation,request('product'),request('quantity'));
            Produit::decrementProduct(request('product'),request('quantity'));
            return back();

        } elseif ($request->has('addShoppingCart')) {

            request()->validate([
                'quantity' => ['bail', 'required', 'min:0']
            ]);
            $panier = Panier::firstOrNewPanier(request('mailClient'));
            Panier::addPriceToThisShoppingCart($panier,request('productPrice'),request('quantity'));

            $commande = Commande::firstOrNewCommande($panier,request('numSiret'));
            Commande::addPriceToThisOrder($commande,request('productPrice'),request('quantity'));

            $detenir = Detenir::firstOrNewDetenir($commande,request('product'));
            Detenir::storeQuantity($detenir,request('quantity'));

            return back();
        }
    }
}
