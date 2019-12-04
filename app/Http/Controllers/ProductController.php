<?php

namespace App\Http\Controllers;

use App\Exceptions\ProductNotBelongsToUser;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\Product\ProductCollection;
use App\Http\Resources\Product\ProductResource;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth:api')->except('index','show');
    }

    public function index()
    {
        return ProductCollection::collection(Product::paginate(15));
    }

   
    public function store(ProductRequest $request)
    {
        $product=new Product;
        $product->name=$request->name;
        $product->detail=$request->description;
        $product->price=$request->price;
        $product->stock=$request->stock;
        $product->discount=$request->discount;
        $product->save();
        
        return response([
            'data'=>new ProductResource($product)
        ],Response::HTTP_CREATED);
        
    }

    
    public function show(Product $product)
    {
        return new ProductResource($product);
    }

   
    
    public function update(Request $request, Product $product)
    {   
        $this->productUserCheck($product);

        $request['detail']=$request->description;
        unset($request['description']);        
        $product->update($request->all());

        return response([
            'data'=>new ProductResource($product)
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {   
        $this->productUserCheck($product);
        $product->delete();
        return response(null,Response::HTTP_NO_CONTENT);
    }

    public function productUserCheck($product)
    {
        if(Auth::id() !==$product->user_id){
            throw new ProductNotBelongsToUser();
        }
    }
}
