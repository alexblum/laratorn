<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index($searchQuery = null)
    {
        $responseSearchQuery = null;
        if (intval($searchQuery) > 0) {
            $items = Item::find($searchQuery)
                ->get();
        } else if ($searchQuery !== null) {
            $responseSearchQuery = $searchQuery;
            $items = Item::where('name', 'like', '%' . $searchQuery . '%')
                ->get();
        } else {
            $items = Item::limit(25)
                ->get();
        }

        $pageData = [
            'items' => $items,
            'searchQuery' => $responseSearchQuery
        ];

        return view('items', $pageData);
    }

    public function search(Request $request)
    {
        return $this->index($request->searchQuery);
    }
}
