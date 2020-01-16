<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Product;
use Session;
use App\Cart;
use App\Http\Requests\StoreProduct;

class ProductController extends Controller
{


    public function trash()
    {
        $products = Product::onlyTrashed()->paginate(3);
        return view('admin.product.trash',compact('products'));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::paginate(3);
        return view('admin.product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.product.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {

        // dd(request()->extra['prices']);

        $name = $this->makethumbnail($request);

        move_uploaded_file($request->thumbnail,public_path('images/'. $name));
        
        //insert product 
        $product   = Product::create([
            'title'          => $request->title,
            'slug'           => $request->slug,
            'description'    => $request->description,
            'thumbnail'      => $name,
            'status'         => $request->status,
            'options'        => (isset($request->extra))?json_encode($request->extra): null,
            'featured'       => ($request->featured)? $request->featured : 0,
            'price'          => $request->price,
            'discount'       => ($request->discount) ? $request->discount : 0,
            'discount_price' => ($request->discount_price)?$request->discount_price :0
        ]); 
        
        if($product)
        {
            $product->categories()->attach($request->category_id);
            return back()->with('message','Product Successfully Added!');
        }
        else{
            return back()->with('message','Error Inserting Product!');
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
       $categories = Category::with('childrens')->get();
       $products   = Product::with('categories')->paginate(3);
        return view('layouts.products.all',compact('categories','products'));
    }
    
    public function single(Product $product)
    {

        return view('layouts.products.single',compact('product'));
    }

   

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.product.create',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    private function makethumbnail(Request $request)
    {
        $thumbnail = $request->thumbnail;
        $extension = ".".$thumbnail->getClientOriginalExtension();
        $name      = basename($thumbnail->getClientOriginalName(),$extension).time();
        $name      = $name.$extension; 
        return $name;
    }

    public function update(Request $request, Product $product)
    {
        if($request->has('thumbnail'))
        {
            $name               = $this->makethumbnail($request);
            $product->thumbnail = $name;
        }

        $product->title          = $request->title;
        $product->description    = $request->description;
        $product->status         = $request->status;
        $product->featured       = ($request->featured)? $request->featured : 0;
        $product->price          = $request->price;
        $product->discount       = ($request->discount) ? $request->discount : 0;
        $product->discount_price = ($request->discount_price)?$request->discount_price :0;

        $product->categories()->detach();

        if($product->save())
        {
           $product->categories()->attach($request->category_id);
           return back()->with('message','Product Successfully Updated !');
        }
        else{
            return back()->with('message','Error Updating Product !');
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
       //Detach all parent category 

       
       $thumbnail = $product->thumbnail;
       $product->categories()->detach();
       if($product->forceDelete())
       {
           unlink(public_path('images/'.$thumbnail));
           return back()->with('message','Record Successfully Deleted');
       }
       else{
           return back()->with('message','Error Deleting Record');
       }
    }
    
    public function addToCart(Product $product,Request $request)
    {
        // dd(session()->get('cart'));
         $oldCart = Session::has('cart') ? Session::get('cart'):null;
         $qty     = isset($request->qty) ? $request->qty : 1;

         $cart    = new Cart($oldCart);
         $cart->addProduct($product, $qty);
         Session::put('cart',$cart);
         return back()->with('message','Product '.$product->title.' has been successfully added  to Cart!');
    }


    public function remove(Product $product)
    {
        if($product->delete())
        {
            return back()->with('message','Product Successfully Trashed');
        }
        else{
            return back()->with('message','Error Deleting Record');
        }
    }
    
    public function recoverProduct($id)
    {
        $product = Product::withTrashed()->findOrFail($id);

        if($product->restore())
            return back()
                     ->with('message','Product Successfully Restored!');
        else
            return back()->with('message','Error Restoring Product');
    }
    
    // cart section 
    //show cart product in cart view
    public function cart()
    {
       if(!Session::has('cart'))
       {
          return view('layouts.products.cart');
       }
       $cart = Session::get('cart');
       return view('layouts.products.cart',compact('cart'));
    }
    
    //remove product from the cart
    public function removeProduct(Product $product)
    {
         
        $oldCart = Session::has('cart')?Session::get('cart') :null;
        $cart    = new Cart($oldCart);
        $cart->removeProduct($product);
        Session::put('cart',$cart);
        return back()->with('message',"Product ".$product->title." 
         been successfully removed From the Cart");
    }
    
    //update product from the cart 
    public function updateProduct(Product $product,Request $request)
    {
        $oldCart = Session::has('cart')?Session::get('cart') :null;
        $cart    = new Cart($oldCart);
        $cart->updateProduct($product,$request->qty);
        Session::put('cart',$cart);
        return back()->with('message',"Product ".$product->title." 
         been successfully Updated in the Cart");
    }

    
}
