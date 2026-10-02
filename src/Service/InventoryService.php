<?php

namespace App\Service;

use App\Entity\Product;

final class InventoryService
{
    /** @var array<int, int> */
    private array $stock = [];

    /**
     * @param list<Product> $products
     */
    public function __construct(array $products = [])
    {
        foreach ($products as $product) {
            $this->stock[$product->getId()] = $product->getStock();
        }
    }

    public function sell(Product $product, int $quantity): void
    {
        if ($quantity <= 0) {
            throw new \InvalidArgumentException('La quantité vendue doit être positive.');
        }

        if ($quantity > $this->stockOf($product)) {
            throw new \InvalidArgumentException('Stock insuffisant.');
        }

        $this->stock[$product->getId()] -= $quantity;
    }

    public function restock(Product $product, int $quantity): void
    {
        $this->stock[$product->getId()] = $this->stockOf($product) + $quantity;
    }

    public function stockOf(Product $product): int
    {
        return $this->stock[$product->getId()] ?? 0;
    }
}
