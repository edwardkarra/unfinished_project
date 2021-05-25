<?php

namespace App\Http\Controllers;
use Illuminate\Support\Str;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use function MongoDB\BSON\toJSON;

class ItemController extends Controller
{
    public function index(){
        $items = Item::all();
        return $items;
    }
    public function store(Request $request){
        $params = $request->validate([
            'name' => ['required','max:255'],
        ]);
        $user = $this->findUserByToken($request->header('api_token'));

        $params['info'] = json_encode($request['info']);
        $params['created_by'] = $user['name'];
        $item = new Item($params);

        $item->item_id = $this->generateId();

        $item->save();

        return true;
    }

    public function update(Request $request)
    {
        $params = $request->validate([
            'name' => ['max:255'],
            'item_id' => 'required'
        ]);

        $item_id = $request['item_id'];
        $params['info'] = $request['info'];
        $item = Item::all()->find($item_id)->first();
        $item->update($params);
        return $item;
    }

    public function destroy(Request $request){
        $params = $request->validate([
            'name' => ['max:255'],
            'item_id' => 'required'
        ]);
        $item = Item::all()->find($params['item_id'])->first();
        $item->delete();
        return true;
    }

    function findUserByToken($token){
        $user = User::all()->where('api_token',$token)->first();
        return $user;
    }
    function generateId(){
        $item_id = '';
        do{
            $item_id = Str::random(10);
        }
        while(Item::all()->find($item_id) != null);
        return $item_id;
    }
}

