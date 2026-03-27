<?php

namespace App\Models;

class Cart
{
    protected $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function addItem($userId, $productId, $productPrice, $productColor, $productStorage, $quantity)
    {
        $productPrice = $productPrice;

        $stmt = $this->db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch();

        if (!$cart) {
            $stmt = $this->db->prepare("INSERT INTO carts (user_id, total_price) VALUES (?, 0)");
            $stmt->execute([$userId]);
            $cartId = $this->db->lastInsertId();
        } else {
            $cartId = $cart['id'];
        }

        $stmt = $this->db->prepare("SELECT id, quantity FROM cart_items WHERE cart_id = ? AND product_id = ? AND color = ? AND storage = ?");
        $stmt->execute([$cartId, $productId, $productColor, $productStorage]);
        $item = $stmt->fetch();

        if ($item) {
            $newQuantity = $item['quantity'] + $quantity;
            $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$newQuantity, $item['id']]);
        } else {
            $stmt = $this->db->prepare("INSERT INTO cart_items (cart_id, product_id, price, quantity, color, storage) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->execute([$cartId, $productId, $productPrice, $quantity, $productColor, $productStorage]);
        }

        $stmt = $this->db->prepare("UPDATE carts SET total_price = (SELECT SUM(price * quantity) FROM cart_items WHERE cart_id = ?), updated_at = NOW() WHERE id = ?");
        $stmt->execute([$cartId, $cartId]);
    }

    public function getCart($userId)
    {
        $stmt = $this->db->prepare("
            SELECT id, COALESCE(total_price, 0) AS total_price 
            FROM carts 
            WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch();

        return $cart ? $cart : ['id' => null, 'total_price' => 0];
    }

    public function getCartItems($userId)
    {
        $stmt = $this->db->prepare("
            SELECT ci.id, ci.product_id, ci.price, ci.quantity, ci.color, ci.storage, p.name, p.image 
            FROM cart_items ci
            INNER JOIN carts c ON ci.cart_id = c.id
            INNER JOIN phones p ON ci.product_id = p.id
            WHERE c.user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function removeItem($userId, $productId, $productColor, $productStorage)
    {
        $stmt = $this->db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch();

        if ($cart) {
            $cartId = $cart['id'];

            $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = ? AND product_id = ? AND color = ? AND storage = ?");
            $stmt->execute([$cartId, $productId, $productColor, $productStorage]);

            $stmt = $this->db->prepare("UPDATE carts SET total_price = (SELECT COALESCE(SUM(price * quantity), 0) FROM cart_items WHERE cart_id = ?), updated_at = NOW() WHERE id = ?");
            $stmt->execute([$cartId, $cartId]);
        }
    }

    public function clearCart($userId)
    {
        $stmt = $this->db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch();

        if ($cart) {
            $cartId = $cart['id'];

            $stmt = $this->db->prepare("DELETE FROM cart_items WHERE cart_id = ?");
            $stmt->execute([$cartId]);

            $stmt = $this->db->prepare("UPDATE carts SET total_price = 0, updated_at = NOW() WHERE id = ?");
            $stmt->execute([$cartId]);
        }
    }

    public function updateItemQuantityByAction($userId, $cartItemId, $action)
    {
        $stmt = $this->db->prepare("SELECT id FROM carts WHERE user_id = ?");
        $stmt->execute([$userId]);
        $cart = $stmt->fetch();

        if ($cart) {
            $cartId = $cart['id'];

            $stmt = $this->db->prepare("SELECT quantity FROM cart_items WHERE id = ? AND cart_id = ?");
            $stmt->execute([$cartItemId, $cartId]);
            $item = $stmt->fetch();

            if ($item) {
                $currentQuantity = (int)$item['quantity'];

                if ($action === 'increase') {
                    $newQuantity = $currentQuantity + 1;
                } elseif ($action === 'decrease' && $currentQuantity > 1) {
                    $newQuantity = $currentQuantity - 1;
                } else {
                    return;
                }

                $stmt = $this->db->prepare("UPDATE cart_items SET quantity = ?, updated_at = NOW() WHERE id = ? AND cart_id = ?");
                $stmt->execute([$newQuantity, $cartItemId, $cartId]);

                $stmt = $this->db->prepare("UPDATE carts SET total_price = (SELECT SUM(price * quantity) FROM cart_items WHERE cart_id = ?), updated_at = NOW() WHERE id = ?");
                $stmt->execute([$cartId, $cartId]);
            }
        }
    }
}
