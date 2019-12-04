<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Http\Resources\Review\ReviewResource;
use App\Model\Product;
use App\Model\Review;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        return ReviewResource::collection($product->reviews);
    }

    
    public function store(ReviewRequest $request, Product $product)
    {
        $review=new Review($request->all());
        $product->reviews()->save($review);
        return response([
            'data'=>new ReviewResource($review),
        ],Response::HTTP_CREATED);
    }

   
   

   
    public function update(Request $request, Product $product, Review $review)
    {
        $review->update($request->all());
        return response([
            'data'=>new ReviewResource($review),
        ],Response::HTTP_CREATED);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Review  $review
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product, Review $review)
    {
        $review->delete();
        return response(null,Response::HTTP_NO_CONTENT);

    }
}
