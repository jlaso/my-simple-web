<?php

namespace app\models\core;

use app\models\core\Registry;

interface FixturableInterface
{

    /**
     * Generate fixtures
     *
     * @param Registry $fixturesRegistry
     *
     * @return void
     */
    public function generateFixtures(Registry $fixturesRegistry);

    /**
     * Get the order of fixture generation
     *
     * @return int
     */
    public static function getOrder();

}