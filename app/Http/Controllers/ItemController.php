<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index($searchQuery = null)
    {
        $responseSearchQuery = $searchQuery;
        if (intval($searchQuery) > 0) {
            $items = [Item::find($searchQuery)];
        } else if ($searchQuery !== null) {
            $items = Item::where('name', 'like', '%' . $searchQuery . '%')
                ->get();
        } else {
            $responseSearchQuery = '';
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
