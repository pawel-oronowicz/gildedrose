<?php

namespace App;

final class GildedRose
{
    const MAX_QUALITY = 50;
    const LEGENDARY_QUALITY = 80;
    
    public function updateQuality($item)
    {
        $is_common_item = true;

        if($item->name === 'Aged Brie') {
            $is_common_item = false;
        }

        if($item->name === 'Backstage passes to a TAFKAL80ETC concert') {
            $is_common_item = false;
        }

        if($item->name === 'Sulfuras, Hand of Ragnaros') {
            $is_common_item = false;
        }

        if($is_common_item) {
            $this->calculateCommonItem($item);
        }

        if ($item->name != 'Aged Brie' and $item->name != 'Backstage passes to a TAFKAL80ETC concert') {
            if ($item->quality > 0) {
                if ($item->name === 'Sulfuras, Hand of Ragnaros') {
                    $item->quality = 80;
                }
            }
        } else {
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

    public function calculateCommonItem(Item $item) {
        $item->sell_in--;

        if($item->quality !== 0) {
            $item->quality--;

            if($item->sell_in < 0 && $item->quality > 0) {
                $item->quality--;
            }
        }
    }

}