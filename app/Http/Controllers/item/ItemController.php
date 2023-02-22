<?php

namespace App\Http\Controllers\item;

use App\Http\Controllers\Controller;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $item;

    public function __construct(Item $item)
    {
        $this->item = $item;

    }

    public function getAllItems()
    {
        try {
            return response()->json(['success' => true, 'items' => $this->item->all()]);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
    public function createItem(Request $request)
    {
        try {
            $dados['name'] = $request['name'];
            $dados['qty'] = $request['qty'];
            $dados['price'] = $request['price'];
            $dados['created_at'] = now();
            $this->item->insert($dados);

            return response()->json(['success' => true, 'message' => 'Successfully created item!']);
        } catch (\Exception $exception) {
            return response()->json(['success' => false, 'message' => $exception->getMessage()], 500);
        }
    }
}
