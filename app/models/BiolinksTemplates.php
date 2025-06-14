<?php
/*
 * Copyright (c) 2025 AltumCode (https://altumcode.com/)
 *
 * This software is licensed exclusively by AltumCode and is sold only via https://altumcode.com/.
 * Unauthorized distribution, modification, or use of this software without a valid license is not permitted and may be subject to applicable legal actions.
 *
 * 🌍 View all other existing AltumCode projects via https://altumcode.com/
 * 📧 Get in touch for support or general queries via https://altumcode.com/contact
 * 📤 Download the latest version via https://altumcode.com/downloads
 *
 * 🐦 X/Twitter: https://x.com/AltumCode
 * 📘 Facebook: https://facebook.com/altumcode
 * 📸 Instagram: https://instagram.com/altumcode
 */

namespace Altum\models;

defined('ALTUMCODE') || die();

class BiolinksTemplates extends Model {

    public function get_biolinks_templates() {

        /* Get the user pixels */
        $biolinks_templates = [];

        /* Try to check if the user exists via the cache */
        $cache_instance = cache()->getItem('biolinks_templates');

        /* Set cache if not existing */
        if(is_null($cache_instance->get())) {

            /* Get data from the database */
            $biolinks_templates_result = database()->query("SELECT * FROM `biolinks_templates` WHERE `is_enabled` = 1 ORDER BY `order`");
            while($row = $biolinks_templates_result->fetch_object()) {
                $row->settings = json_decode($row->settings ?? '');
                $biolinks_templates[$row->biolink_template_id] = $row;
            }

            cache()->save(
                $cache_instance->set($biolinks_templates)->expiresAfter(CACHE_DEFAULT_SECONDS)
            );

        } else {

            /* Get cache */
            $biolinks_templates = $cache_instance->get();

        }

        return $biolinks_templates;

    }

}
