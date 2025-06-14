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

namespace Altum\Controllers;

use Altum\Alerts;

defined('ALTUMCODE') || die();

class AdminTemplateCategoryUpdate extends Controller {

    public function index() {

        if(!\Altum\Plugin::is_active('aix')) {
            redirect('not-found');
        }

        $template_category_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        if(!$template_category = db()->where('template_category_id', $template_category_id)->getOne('templates_categories')) {
            redirect('admin/template-categories');
        }

        $template_category->settings = json_decode($template_category->settings ?? '');

        if(!empty($_POST)) {
            /* Filter some the variables */
            $_POST['name'] = input_clean($_POST['name'], 64);
            $_POST['icon'] = input_clean($_POST['icon'], 64);
            $_POST['emoji'] = input_clean($_POST['emoji'], 64);
            $_POST['color'] = !verify_hex_color($_POST['color']) ? '#ffffff' : $_POST['color'];
            $_POST['background'] = !verify_hex_color($_POST['background']) ? '#000000' : $_POST['background'];
            $_POST['order'] = (int) $_POST['order'] ?? 0;
            $_POST['is_enabled'] = (int) isset($_POST['is_enabled']);

            foreach($_POST['translations'] as $language_name => $array) {
                foreach($array as $key => $value) {
                    $_POST['translations'][$language_name][$key] = input_clean($value);
                }
                if(!array_key_exists($language_name, \Altum\Language::$active_languages)) {
                    unset($_POST['translations'][$language_name]);
                }
            }

            $settings = json_encode(['translations' => $_POST['translations']]);

            //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

            if(!\Altum\Csrf::check()) {
                Alerts::add_error(l('global.error_message.invalid_csrf_token'));
            }

            if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

                /* Database query */
                db()->where('template_category_id', $template_category_id)->update('templates_categories', [
                    'name' => $_POST['name'],
                    'settings' => $settings,
                    'icon' => $_POST['icon'],
                    'emoji' => $_POST['emoji'],
                    'color' => $_POST['color'],
                    'background' => $_POST['background'],
                    'order' => $_POST['order'],
                    'is_enabled' => $_POST['is_enabled'],
                    'last_datetime' => get_date(),
                ]);

                /* Clear the cache */
                cache()->deleteItem('templates_categories');

                /* Set a nice success message */
                Alerts::add_success(sprintf(l('global.success_message.update1'), '<strong>' . $_POST['name'] . '</strong>'));

                /* Refresh the page */
                redirect('admin/template-category-update/' . $template_category_id);

            }

        }

        /* Main View */
        $data = [
            'template_category_id'       => $template_category_id,
            'template_category'          => $template_category,
        ];

        $view = new \Altum\View('admin/template-category-update/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

}
