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

class AdminDocuments extends Controller {

    public function index() {

        if(!\Altum\Plugin::is_active('aix')) {
            redirect('not-found');
        }

        /* Prepare the filtering system */
        $filters = (new \Altum\Filters(['user_id', 'project_id', 'template_id', 'template_category_id'], ['name'], ['document_id', 'last_datetime', 'datetime', 'name', 'words']));
        $filters->set_default_order_by($this->user->preferences->documents_default_order_by, $this->user->preferences->default_order_type ?? settings()->main->default_order_type);
        $filters->set_default_results_per_page($this->user->preferences->default_results_per_page ?? settings()->main->default_results_per_page);

        /* Prepare the paginator */
        $total_rows = database()->query("SELECT COUNT(*) AS `total` FROM `documents` WHERE 1 = 1 {$filters->get_sql_where()}")->fetch_object()->total ?? 0;
        $paginator = (new \Altum\Paginator($total_rows, $filters->get_results_per_page(), $_GET['page'] ?? 1, url('admin/documents?' . $filters->get_get() . '&page=%d')));

        /* Get the data */
        $documents = [];
        $documents_result = database()->query("
            SELECT
                `documents`.*, `users`.`name` AS `user_name`, `users`.`email` AS `user_email`, `users`.`avatar` AS `user_avatar`
            FROM
                `documents`
            LEFT JOIN
                `users` ON `documents`.`user_id` = `users`.`user_id`
            WHERE
                1 = 1
                {$filters->get_sql_where('documents')}
                {$filters->get_sql_order_by('documents')}

            {$paginator->get_sql_limit()}
        ");
        while($row = $documents_result->fetch_object()) {
            $row->settings = json_decode($row->settings ?? '');
            $documents[] = $row;
        }

        /* Export handler */
        process_export_csv($documents, 'include', ['document_id', 'template_id', 'template_category_id', 'project_id', 'user_id', 'name', 'type', 'content', 'words', 'model', 'api_response_time', 'datetime', 'last_datetime'], sprintf(l('documents.title')));
        process_export_json($documents, 'include', ['document_id', 'template_id', 'template_category_id', 'project_id', 'user_id', 'name', 'type', 'content', 'words', 'model', 'api_response_time', 'settings', 'datetime', 'last_datetime'], sprintf(l('documents.title')));

        /* Prepare the pagination view */
        $pagination = (new \Altum\View('partials/admin_pagination', (array) $this))->run(['paginator' => $paginator]);

        /* Get available templates categories */
        $templates_categories = (new \Altum\Models\TemplatesCategories())->get_templates_categories();

        /* Templates */
        $templates = (new \Altum\Models\Templates())->get_templates();

        /* Main View */
        $data = [
            'documents' => $documents,
            'filters' => $filters,
            'pagination' => $pagination,
            'templates' => $templates,
            'templates_categories' => $templates_categories,
        ];

        $view = new \Altum\View('admin/documents/index', (array) $this);

        $this->add_view_content('content', $view->run($data));

    }

    public function bulk() {

        /* Check for any errors */
        if(empty($_POST)) {
            redirect('admin/documents');
        }

        if(empty($_POST['selected'])) {
            redirect('admin/documents');
        }

        if(!isset($_POST['type'])) {
            redirect('admin/documents');
        }

        //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

        if(!\Altum\Csrf::check()) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
        }

        if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

            set_time_limit(0);

            switch($_POST['type']) {
                case 'delete':

                    foreach($_POST['selected'] as $document_id) {

                        $document = db()->where('document_id', $document_id)->getOne('documents', ['document_id']);

                        /* Delete the resource */
                        db()->where('document_id', $document->document_id)->delete('documents');

                    }

                    break;
            }

            /* Set a nice success message */
            Alerts::add_success(l('bulk_delete_modal.success_message'));

        }

        redirect('admin/documents');
    }

    public function delete() {

        $document_id = isset($this->params[0]) ? (int) $this->params[0] : null;

        //ALTUMCODE:DEMO if(DEMO) Alerts::add_error('This command is blocked on the demo.');

        if(!\Altum\Csrf::check('global_token')) {
            Alerts::add_error(l('global.error_message.invalid_csrf_token'));
        }

        if(!$document = db()->where('document_id', $document_id)->getOne('documents', ['document_id', 'user_id', 'name'])) {
            redirect('admin/documents');
        }

        if(!Alerts::has_field_errors() && !Alerts::has_errors()) {

            /* Delete the resource */
            db()->where('document_id', $document->document_id)->delete('documents');

            /* Set a nice success message */
            Alerts::add_success(sprintf(l('global.success_message.delete1'), '<strong>' . $document->name . '</strong>'));

        }

        redirect('admin/documents');
    }

}
