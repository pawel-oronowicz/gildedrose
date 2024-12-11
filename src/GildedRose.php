<?php

namespace App;

final class GildedRose
{
    const MAX_QUALITY = 50;
    const LEGENDARY_QUALITY = 80;
    
    public function updateQuality($item): void
    {
        $is_common_item = true;

        if($item->name === 'Aged Brie') {
            $is_common_item = false;
            $this->calculateAgedBrie($item);
        }

        if($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
            $is_common_item = false;
            $this->calculateBackstagePasses($item);
        }

        if($item->name === 'Sulfuras, Hand of Ragnaros') {
            $is_common_item = false;
            $this->calculateSulfuras($item);
        }

        if($is_common_item) {
            $this->calculateCommonItem($item);
        }

        if ($item->name === 'Aged Brie' || $item->name === 'Backstage passes to a TAFKAL80ETC concert') {
            if ($item->quality < 50) {
                $item->quality = $item->quality + 1;
                if ($item->name == 'Backstage passes to a TAFKAL80ETC concert') {
                    if ($item->sell_in < 11) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                    if ($item->sell_in < 6) {
                        if ($item->quality < 50) {
                            $item->quality = $item->quality + 1;
                        }
                    }
                }
            }
        }

        if ($item->name != 'Sulfuras, Hand of Ragnaros' && !$is_common_item) {
            $item->sell_in = $item->sell_in - 1;
        }

        if ($item->sell_in < 0) {
            if ($item->name != 'Aged Brie') {
                if ($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
                    $item->quality = $item->quality - $item->quality;
                }
            } else {
                if ($item->quality < 50) {
                    $item->quality = $item->quality + 1;
                }
            }
        }
    }

    /**
     * Calculate quality and sell-in for a common item
     * @param Item $item
     * @return void
     */
    public function calculateCommonItem(Item $item): void
    {
        $item->sell_in--;

        if($item->quality !== 0) {
            $item->quality--;

            // after expiry date
            if($item->sell_in < 0 && $item->quality > 0) {
                $item->quality--;
            }
        }
    }

    public function calculateBackstagePasses(Item $item): void
    {

    }

    /**
     * Calculate quality for static Sulfuras item
     * @param Item $item
     * @return void
     */
    public function calculateSulfuras(Item $item): void
    {
        $item->quality = self::LEGENDARY_QUALITY;
    }

    public function calculateAgedBrie(Item $item): void
    {

    }

}