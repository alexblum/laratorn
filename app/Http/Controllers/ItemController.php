<?php

namespace App\Http\Controllers;

use App\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * @param null $searchQuery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
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

    /**
     * @param null $searchQuery
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function indexvue($searchQuery = null)
    {
        return view('itemsvue', [$searchQuery]);
    }

    /**
     * @param null $searchQuery
     * @return array
     */
    public function indexjson(Request $request, $searchQuery = null)
    {
        $orderBy = $request->input('sortby');
        if (empty($orderBy)) {
            $orderBy = 'id';
        }

        $order = $request->input('sortorder');
        if (empty($order)) {
            $order = 'asc';
        }

        $responseSearchQuery = $searchQuery;
        if (intval($searchQuery) > 0) {
            $items = [Item::find($searchQuery)];
        } else if ($searchQuery !== null) {
            $items = Item::where('name', 'like', '%' . $searchQuery . '%')
                ->orderBy($orderBy, $order)
                ->paginate(15);
        } else {
            $responseSearchQuery = '';
            $items = Item::orderBy($orderBy, $order)->paginate(15);
        }

        $pageData = [
            'items' => $items,
            'searchQuery' => $responseSearchQuery
        ];

        return $pageData;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        return $this->index($request->searchQuery);
    }
}
