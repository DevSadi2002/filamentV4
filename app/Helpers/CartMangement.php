<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cookie;
use App\Models\Product;

class CartMangement
{
    // إرجاع جميع العناصر من الكوكيز
    public static function getCartItemsFromCookie(): array
    {
        $cart_items = json_decode(Cookie::get('cart_items', '[]'), true);
        return is_array($cart_items) ? $cart_items : [];
    }

    // تخزين العناصر في الكوكيز
    protected static function saveCartItems(array $items): void
    {
        Cookie::queue('cart_items', json_encode($items), 60 * 24 * 30);
    }

    // إضافة منتج للسلة
    public static function addItem(int $product_id, int $quantity = 1): int
    {
        $items = self::getCartItemsFromCookie();
        $index = array_search($product_id, array_column($items, 'product_id'));

        if ($index !== false) {
            $items[$index]['quantity'] += $quantity;
            $items[$index]['total_amount'] = $items[$index]['quantity'] * $items[$index]['unit_amount'];
        } else {
            // $product = Product::select('id', 'name', 'price', 'image')->find($product_id);
            $product = Product::where('id', $product_id)->first([
                'id',
                'name',
                'price',
                'image'
            ]);
            if ($product) {
                // // تأكد إنه image إما مصفوفة أو JSON
                // $image = $product->image;

                // if (is_string($image)) {
                //     // إذا مخزن نص (إما مسار واحد أو JSON string)
                //     $decoded = json_decode($image, true);
                //     $image = is_array($decoded) ? $decoded[0] : $image;
                // } elseif (is_array($image)) {
                //     // إذا إجا مصفوفة من العلاقة مباشرة
                //     $image = $image[0] ?? null;
                // }

                $items[] = [
                    'product_id'   => $product->id,
                    'image'        => $product->image[0], // صورة وحدة فقط
                    'name'         => $product->name,
                    'quantity'     => $quantity,
                    'unit_amount'  => $product->price,
                    'total_amount' => $product->price * $quantity,
                ];
            }
        }

        self::saveCartItems($items);
        return count($items);
    }

    // تحديث كمية منتج
    public static function updateQuantity(int $product_id, int $quantity): array
    {
        $items = self::getCartItemsFromCookie();
        $index = array_search($product_id, array_column($items, 'product_id'));

        if ($index !== false && $quantity > 0) {
            $items[$index]['quantity'] = $quantity;
            $items[$index]['total_amount'] = $quantity * $items[$index]['unit_amount'];
        }

        self::saveCartItems($items);
        return $items;
    }

    // إزالة منتج من السلة
    public static function removeItem(int $product_id): array
    {
        $items = array_filter(
            self::getCartItemsFromCookie(),
            fn($item) => $item['product_id'] != $product_id
        );

        self::saveCartItems($items);
        return $items;
    }

    // مسح السلة
    public static function clearCart(): void
    {
        Cookie::queue(Cookie::forget('cart_items'));
    }



    // increment item quantity static
    public static function incrementItemQuantityToCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $index => $item) {
            if ($item['product_id'] == $product_id) {
                $cart_items[$index]['quantity']++;
                $cart_items[$index]['total_amount'] = $cart_items[$index]['quantity'] * $cart_items[$index]['unit_amount'];
                break;
            }
        }
        self::saveCartItems($cart_items);
        return $cart_items;
    } // decrement item quantity static
    public static function decrementItemQuantityToCart($product_id)
    {
        $cart_items = self::getCartItemsFromCookie();
        foreach ($cart_items as $index => $item) {
            if ($item['product_id'] == $product_id) {
                if ($cart_items[$index]['quantity'] > 1) {
                    $cart_items[$index]['quantity']--;
                    $cart_items[$index]['total_amount'] = $cart_items[$index]['quantity'] * $cart_items[$index]['unit_amount'];
                }
                break;
            }
        }
        self::saveCartItems($cart_items);
        return $cart_items;
    }




    // حساب المجموع الكلي
    public static function calculateGrandTotal(array $items): float
    {
        return array_sum(array_column($items, 'total_amount'));
    }
}
