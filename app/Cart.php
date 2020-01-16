<?php 

namespace App;


class Cart 
{
    public $contents;
    public  $totalQty;
    public $totalPrice;

    public function __construct($oldCart)
    {
        if($oldCart)
        {
            $this->contents   = $oldCart->contents;
            $this->totalQty   = $oldCart->totalQty;
            $this->totalPrice = $oldCart->totalPrice;
        }
    }

    public function addProduct($product,$qty=1)
    {
        $products = ['qty' => 0,'price'=>$product->price,'product'=>$product];

        if($this->contents)
        {
            //check if product already exist in array 
            if(array_key_exists($product->slug,$this->contents)){
                  $products    =  $this->contents[$product->slug];
            }
        }
         
        // update quantity of the products
        $products['qty']               += $qty; 
        //update price of the products 
        $products['price']              = $product->price * $qty;
        //add product in content array 
        $this->contents[$product->slug] = $products;
        //update total quantity 
        $this->totalQty                 += $qty;
        //update total price 
        $this->totalPrice               += $products['price'];

    }

    public function removeProduct($product)
    {

        if($this->contents)
        {
             if(array_key_exists($product->slug,$this->contents))
             {

                 $removeProduct     = $this->contents[$product->slug];
                 $this->totalQty   -= $removeProduct['qty']; 
                 $this->totalPrice -= $removeProduct['price'];

                 if($this->totalPrice < 0 || $this->totalQty < 0 )
                 {
                     $this->totalPrice = 0;
                     $this->totalQty   = 0;
                 }
                 array_forget($this->contents,$product->slug);
             }
        }
    }

    public function updateProduct($product,$qty)
    {

        if($this->contents)
        {
             if(array_key_exists($product->slug,$this->contents))
             {

                $products            = $this->contents[$product->slug];
                //minus old qty from total quantity 
                $this->totalQty     -= $products['qty'] ;
                //minus old price from total price 
                $this->totalPrice   -= $products['price'];
                $products['qty']     = $qty; 
                //update price of the products 
                $products['price']   = $product->price * $qty;
                //add product in content array 
                $this->contents[$product->slug] = $products;
                //update total quantity 
                $this->totalQty     += $qty;
                //update total price 
                $this->totalPrice   += $products['price'];
             }
        }
    }

    public function getContents()
    {
        return $this->contents;
    }
    public function getTotalQty()
    {
        return $this->totalQty;
    }
    public function getTotalPrice()
    {
        return $this->totalPrice;
    }
}
