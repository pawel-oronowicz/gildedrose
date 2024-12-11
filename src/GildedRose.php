<?php

namespace App;

final class GildedRose
{
    const DEFAULT_MAX_QUALITY = 50;
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

        if ($item->name !== 'Sulfuras, Hand of Ragnaros') {
            $item->sell_in = $item->sell_in - 1;
        }
    }

    /**
     * Calculate quality and sell-in for a common item
     * @param Item $item
     * @return void
     */
    public function calculateCommonItem(Item $item): void
    {
        if($item->quality !== 0) {
            $item->quality--;

            // after expiry date
            if($item->sell_in <= 0 && $item->quality > 0) {
                $item->quality--;
            }
        }
    }

    /**
     * Calculate quality and sell-in for BackstagePass item
     * @param Item $item
     * @return void
     */
    public function calculateBackstagePasses(Item $item): void
    {
        if($item->sell_in <= 0) {
            $item->quality = 0;
        } elseif($item->quality < self::DEFAULT_MAX_QUALITY) {
            $item->quality++;

            // when 10 days or less and the item is still below max quality
            if($item->sell_in <= 10 && $item->quality < self::DEFAULT_MAX_QUALITY) {
                $item->quality++;
            }

            // when 10 days or less and the item is still below max quality
            if($item->sell_in <= 5 && $item->quality < self::DEFAULT_MAX_QUALITY) {
                $item->quality++;
            }
        }
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

    /**
     * Calculate quality for AgedBrie item
     * @param Item $item
     * @return void
     */
    public function calculateAgedBrie(Item $item): void
    {
        if($item->quality < self::DEFAULT_MAX_QUALITY) {
            $item->quality++;
        }

        // after expiry date and when the item is still below max quality
        if($item->sell_in <= 0 && $item->quality < self::DEFAULT_MAX_QUALITY) {
            $item->quality++;
        }
    }

}