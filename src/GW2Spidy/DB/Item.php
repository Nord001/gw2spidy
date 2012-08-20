<?php

namespace GW2Spidy\DB;

use GW2Spidy\Util\ApplicationCache;
use GW2Spidy\DB\om\BaseItem;


/**
 * Skeleton subclass for representing a row from the 'item' table.
 *
 *
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    propel.generator.gw2spidy
 */
class Item extends BaseItem {
    const RARITY_COMMON = 1;

    public function getRarityName() {
        switch ($this->getRarity()) {
            case self::RARITY_COMMON:    return "Common";
            default:                     return "Rarity [{$this->getRarity()}]";
        }
    }

    public function getRarityCSSClass() {
        return strtolower(str_replace(" ", "-", $this->getRarityName()));
    }

    /**
     * Get the associated ItemSubType object
     *
     * @param      PropelPDO   $con    Optional Connection object.
     * @return     ItemSubType         The associated ItemSubType object.
     * @throws     PropelException
     */
    public function getItemSubType(PropelPDO $con = null) {
        if ($this->aItemSubType === null && ($this->item_sub_type_id !== null)) {
            $cacheKey            = __CLASS__ . "::" . __METHOD__ . "::" . $this->getDataId();
            $this->aItemSubType  = ApplicationCache::getInstance()->get($cacheKey);

            if (!$this->aItemSubType) {
                $this->aItemSubType = ItemSubTypeQuery::create()
                    ->filterByItem($this)
                    ->filterByMainTypeId($this->getItemTypeId())
                    ->findOne($con);

                ApplicationCache::getInstance()->set($cacheKey, $this->aItemSubType, MEMCACHE_COMPRESSED, 86400);
            }
        }

        return $this->aItemSubType;
    }

} // Item
